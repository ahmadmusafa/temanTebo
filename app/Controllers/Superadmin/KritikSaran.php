<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\KritikSaranModel;

class KritikSaran extends BaseController
{
    private const PER_HALAMAN = 10;

    public function index()
    {
        $jenis = (string) $this->request->getGet('jenis');
        $q     = trim((string) $this->request->getGet('q'));
        $page  = max(1, (int) $this->request->getGet('page'));

        if (! in_array($jenis, ['kritik', 'saran'], true)) {
            $jenis = '';
        }

        $model = new KritikSaranModel();

        if ($jenis !== '') {
            $model->where('jenis', $jenis);
        }

        if ($q !== '') {
            $model->groupStart()
                ->like('nama', $q)
                ->orLike('email', $q)
                ->orLike('pesan', $q)
            ->groupEnd();
        }

        $total        = $model->countAllResults(false);
        $totalHalaman = max(1, (int) ceil($total / self::PER_HALAMAN));
        $page         = min($page, $totalHalaman);

        $daftar = $model
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll(self::PER_HALAMAN, ($page - 1) * self::PER_HALAMAN);

        return view('superadmin/kritiksaran/index', [
            'title'        => 'Kritik & Saran',
            'daftar'       => $daftar,
            'total'        => $total,
            'jenis'        => $jenis,
            'q'            => $q,
            'halaman'      => $page,
            'totalHalaman' => $totalHalaman,
            'perPage'      => self::PER_HALAMAN,
        ]);
    }

    public function hapus($id = null)
    {
        $jenis = (string) $this->request->getPost('jenis');
        $q     = trim((string) $this->request->getPost('q'));
        $page  = (int) $this->request->getPost('page');

        if (! in_array($jenis, ['kritik', 'saran'], true)) {
            $jenis = '';
        }

        $model = new KritikSaranModel();
        $id    = (int) $id;

        if ($id < 1 || $model->find($id) === null) {
            return redirect()->to($this->urlKembali($jenis, $q, $page))
                ->with('ks_error', 'Data tidak ditemukan atau sudah dihapus.');
        }

        $model->delete($id);

        // Jika halaman jadi kosong setelah hapus, mundur ke halaman terakhir yang berisi
        $sisa = new KritikSaranModel();
        if ($jenis !== '') {
            $sisa->where('jenis', $jenis);
        }
        if ($q !== '') {
            $sisa->groupStart()
                ->like('nama', $q)
                ->orLike('email', $q)
                ->orLike('pesan', $q)
            ->groupEnd();
        }
        $maxHal = max(1, (int) ceil($sisa->countAllResults() / self::PER_HALAMAN));
        $page   = min($page, $maxHal);

        return redirect()->to($this->urlKembali($jenis, $q, $page))
            ->with('ks_success', 'Masukan berhasil dihapus.');
    }

    private function urlKembali(string $jenis, string $q, int $page): string
    {
        $query = array_filter([
            'jenis' => $jenis,
            'q'     => $q,
            'page'  => $page > 1 ? $page : '',
        ], static fn ($v) => $v !== '');

        return site_url('superadmin/kritiksaran')
            . ($query ? '?' . http_build_query($query) : '');
    }
}