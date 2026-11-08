<?php

namespace App\Controllers;

use App\Models\StatistikModel;
use App\Models\KegiatanModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index()
    {
        $statistik = (new StatistikModel())->first();

        // Ambil maksimal 3 kegiatan aktif untuk halaman beranda
        $kegiatan = (new KegiatanModel())
            ->where('aktif', 1)
            ->orderBy('tanggal', 'ASC')
            ->findAll(3);

        return view('pages/beranda', [
            'title'     => 'Beranda',
            'statistik' => $statistik,
            'kegiatan'  => $kegiatan,
        ]);
    }

    public function kegiatan()
    {
        $kegiatan = (new KegiatanModel())
            ->where('aktif', 1)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        return view('pages/kegiatan', [
            'title'    => 'Kegiatan',
            'kegiatan' => $kegiatan,
        ]);
    }

    public function gambar(string $namaFile)
    {
        $namaFile = basename($namaFile);
        $path = WRITEPATH . 'uploads/kegiatan/' . $namaFile;

        if (! is_file($path)) {
            throw PageNotFoundException::forPageNotFound(
                'Gambar kegiatan tidak ditemukan.'
            );
        }

        $mime = mime_content_type($path);

        $mimeDiizinkan = [
            'image/jpeg',
            'image/png',
            'image/webp',
        ];

        if (! in_array($mime, $mimeDiizinkan, true)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setBody(file_get_contents($path));
    }

    public function komunitas()
    {
        return view('pages/komunitas', [
            'title' => 'Komunitas',
        ]);
    }

    public function dampak()
    {
        return view('pages/dampak', [
            'title' => 'Dampak Sosial',
        ]);
    }

    public function tentangKami()
    {
        return view('pages/tentangKami', [
            'title' => 'Tentang Kami',
        ]);
    }

    public function kontak()
    {
        return view('pages/kontak', [
            'title' => 'Kontak',
        ]);
    }

    public function login()
    {
        return view('pages/login', [
            'title' => 'Masuk',
        ]);
    }
}
