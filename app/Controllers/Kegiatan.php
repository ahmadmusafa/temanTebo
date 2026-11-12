<?php

namespace App\Controllers;

use App\Services\KegiatanService;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class Kegiatan extends BaseController
{
    protected KegiatanService $service;

    public function __construct()
    {
        $this->service = new KegiatanService();
    }

    // Halaman daftar kegiatan
    public function index()
    {
        $kegiatan = $this->service->semua();

        // Hanya tampilkan kegiatan yang aktif
        $kegiatan = array_filter($kegiatan, static function ($event) {
            return (int) ($event['aktif'] ?? 0) === 1;
        });

        return view('pages/kegiatan', [
            'kegiatan' => array_values($kegiatan),
        ]);
    }

    // Menampilkan gambar kegiatan
    public function gambar(string $namaFile): ResponseInterface
    {
        $path = WRITEPATH . 'uploads/kegiatan/' . basename($namaFile);

        if (! is_file($path)) {
            throw PageNotFoundException::forPageNotFound(
                'Gambar kegiatan tidak ditemukan.'
            );
        }

        $mime = mime_content_type($path);

        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setContentType($mime)
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setBody(file_get_contents($path));
    }
}
