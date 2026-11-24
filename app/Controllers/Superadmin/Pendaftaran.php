<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Services\PendaftaranService;
use Config\Database;

class Pendaftaran extends BaseController
{
    protected PendaftaranService $pendaftaranService;

    public function __construct()
    {
        $this->pendaftaranService = new PendaftaranService();
    }

    /**
     * Menampilkan daftar pendaftaran.
     */
    public function index()
    {
        $db = Database::connect();

        $pendaftaran = $db->table('pendaftaran p')
            ->select('
                p.*,
                k.judul AS nama_kegiatan,
                k.tanggal AS tanggal_kegiatan,
                k.jenis_biaya,
                k.biaya_pendaftaran
            ')
            ->join('kegiatan k', 'k.id = p.id_kegiatan')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $total = count($pendaftaran);

        $menunggu = 0;
        $diterima = 0;
        $ditolak = 0;

        foreach ($pendaftaran as $item) {
            switch ($item['status_pendaftaran']) {
                case 'menunggu_verifikasi':
                    $menunggu++;
                    break;

                case 'diterima':
                    $diterima++;
                    break;

                case 'ditolak':
                    $ditolak++;
                    break;
            }
        }

        $data = [
            'title'       => 'Pendaftaran',
            'pendaftaran' => $pendaftaran,
            'total'       => $total,
            'menunggu'    => $menunggu,
            'diterima'    => $diterima,
            'ditolak'     => $ditolak,
        ];

        return view('superadmin/pendaftaran/index', $data);
    }

    /**
     * Menampilkan bukti pembayaran.
     */
    public function bukti(int $id)
    {
        $db = Database::connect();

        $pendaftaran = $db->table('pendaftaran')
            ->select('bukti_pembayaran')
            ->where('id_pendaftaran', $id)
            ->get()
            ->getRowArray();

        if (!$pendaftaran || empty($pendaftaran['bukti_pembayaran'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Bukti pembayaran tidak ditemukan.'
            );
        }

        $namaFile = basename($pendaftaran['bukti_pembayaran']);
        $path = WRITEPATH . 'uploads/bukti_pembayaran/' . $namaFile;

        if (!is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'File bukti pembayaran tidak ditemukan.'
            );
        }

        $mime = mime_content_type($path);

        if (!in_array($mime, [
            'image/jpeg',
            'image/png',
            'application/pdf',
        ], true)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Format file tidak didukung.'
            );
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $namaFile . '"')
            ->setBody(file_get_contents($path));
    }

    /**
     * Menyetujui pendaftaran.
     */
    public function setujui(int $id)
    {
        $hasil = $this->pendaftaranService->setujui($id);

        if (!$hasil['success']) {
            return redirect()->to(site_url('superadmin/pendaftaran'))
                ->with('error', $hasil['message']);
        }

        return redirect()->to(site_url('superadmin/pendaftaran'))
            ->with('success', $hasil['message']);
    }

    /**
     * Menolak pendaftaran.
     */
    public function tolak(int $id)
    {
        $catatan = trim($this->request->getPost('catatan_admin') ?? '');

        $hasil = $this->pendaftaranService->tolak($id, $catatan);

        if (!$hasil['success']) {
            return redirect()->to(site_url('superadmin/pendaftaran'))
                ->with('error', $hasil['message']);
        }

        return redirect()->to(site_url('superadmin/pendaftaran'))
            ->with('success', $hasil['message']);
    }
}
