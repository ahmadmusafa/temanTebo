<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Services\KegiatanService;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class Kegiatan extends BaseController
{
    private const MAX_IMAGE_KB = 2048;
    private const UPLOAD_MIMES = 'image/jpg,image/jpeg,image/png,image/webp';
    private const SERVE_MIMES  = ['image/jpeg', 'image/png', 'image/webp'];
    private const UPLOAD_DIR   = 'uploads/kegiatan/';

    protected KegiatanService $service;

    public function __construct()
    {
        $this->service = new KegiatanService();
    }

    public function index()
    {
        return view('superadmin/kegiatan/index', [
            'kegiatan' => $this->service->semua(),
        ]);
    }

    public function data(int $id): ResponseInterface
    {
        $kegiatan = $this->service->cari($id);

        return $kegiatan
            ? $this->json([
                'status'   => true,
                'kegiatan' => $kegiatan,
            ])
            : $this->json([
                'status'  => false,
                'message' => 'Kegiatan tidak ditemukan.',
            ], 404);
    }

    public function store(): ResponseInterface
    {
        if (! $this->validate($this->rules(true))) {
            return $this->json([
                'status'  => false,
                'message' => 'Periksa kembali data kegiatan.',
                'errors'  => $this->validator->getErrors(),
            ], 422);
        }

        try {
            $this->service->simpan(
                $this->form(),
                $this->request->getFile('gambar')
            );

            return $this->json([
                'status'  => true,
                'message' => 'Kegiatan berhasil ditambahkan.',
            ]);
        } catch (Throwable $e) {
            log_message('error', 'Simpan kegiatan: {message}', [
                'message' => $e->getMessage(),
            ]);

            return $this->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(int $id): ResponseInterface
    {
        if (! $this->service->cari($id)) {
            return $this->json([
                'status'  => false,
                'message' => 'Kegiatan tidak ditemukan.',
            ], 404);
        }

        if (! $this->validate($this->rules(false))) {
            return $this->json([
                'status'  => false,
                'message' => 'Periksa kembali data kegiatan.',
                'errors'  => $this->validator->getErrors(),
            ], 422);
        }

        try {
            $this->service->perbarui(
                $id,
                $this->form(),
                $this->request->getFile('gambar')
            );

            return $this->json([
                'status'  => true,
                'message' => 'Kegiatan berhasil diperbarui.',
            ]);
        } catch (Throwable $e) {
            log_message('error', 'Update kegiatan: {message}', [
                'message' => $e->getMessage(),
            ]);

            return $this->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $this->service->hapus($id);

            return redirect()
                ->to('/superadmin/kegiatan')
                ->with('success', 'Kegiatan berhasil dihapus.');
        } catch (Throwable $e) {
            log_message('error', 'Hapus kegiatan: {message}', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->to('/superadmin/kegiatan')
                ->with('error', $e->getMessage());
        }
    }

    public function gambar(string $namaFile): ResponseInterface
    {
        $path = WRITEPATH . self::UPLOAD_DIR . basename($namaFile);

        if (! is_file($path)) {
            throw PageNotFoundException::forPageNotFound(
                'Gambar kegiatan tidak ditemukan.'
            );
        }

        $mime = mime_content_type($path);

        if (! in_array($mime, self::SERVE_MIMES, true)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setContentType($mime)
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setBody(file_get_contents($path));
    }

    // ================= VALIDASI =================

    private function rules(bool $requireImage): array
    {
        return [
            'judul'              => 'required|min_length[3]|max_length[150]',
            'kategori'           => 'required|max_length[100]',
            'tanggal'            => 'required|valid_date[Y-m-d]',
            'jam'                => 'permit_empty|max_length[50]',
            'lokasi'             => 'required|max_length[200]',
            'deskripsi'          => 'required',
            'kuota'              => 'required|integer|greater_than[0]',
            'batas_pendaftaran'  => 'permit_empty|valid_date[Y-m-d]',
            'jenis_biaya'        => 'required|in_list[gratis,berbayar]',
            'biaya_pendaftaran'  => 'permit_empty|integer|greater_than_equal_to[0]',
            'status_pendaftaran' => 'required|in_list[dibuka,ditutup]',
            'aktif'              => 'required|in_list[0,1]',

            'gambar' => [
                'label' => 'Gambar kegiatan',
                'rules' => sprintf(
                    '%s|is_image[gambar]|mime_in[gambar,%s]|max_size[gambar,%d]',
                    $requireImage ? 'uploaded[gambar]' : 'if_exist',
                    self::UPLOAD_MIMES,
                    self::MAX_IMAGE_KB
                ),
            ],
        ];
    }

    // ================= DATA FORM =================

    private function form(): array
    {
        $jenisBiaya = $this->request->getPost('jenis_biaya');

        $biaya = $this->request->getPost('biaya_pendaftaran');

        return [
            'judul'              => $this->request->getPost('judul'),
            'kategori'           => $this->request->getPost('kategori'),
            'tanggal'             => $this->request->getPost('tanggal'),
            'jam'                 => $this->request->getPost('jam'),
            'lokasi'              => $this->request->getPost('lokasi'),
            'deskripsi'           => $this->request->getPost('deskripsi'),
            'kuota'               => $this->request->getPost('kuota'),
            'batas_pendaftaran'   => $this->request->getPost('batas_pendaftaran') ?: null,
            'jenis_biaya'         => $jenisBiaya,
            'biaya_pendaftaran'   => $jenisBiaya === 'gratis' ? 0 : (int) $biaya,
            'status_pendaftaran'  => $this->request->getPost('status_pendaftaran'),
            'aktif'               => $this->request->getPost('aktif'),
        ];
    }
}
