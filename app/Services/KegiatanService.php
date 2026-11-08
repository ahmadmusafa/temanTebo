<?php

namespace App\Services;

use App\Models\KegiatanModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class KegiatanService
{
    private const DIR  = 'uploads/kegiatan/';
    private const PERM = 0755;

    protected KegiatanModel $model;

    public function __construct()
    {
        $this->model = new KegiatanModel();
    }

    public function semua(): array
    {
        return $this->model->orderBy('tanggal', 'DESC')->findAll();
    }

    public function cari(int $id): ?array
    {
        return $this->model->find($id) ?: null;
    }

    public function simpan(array $data, ?UploadedFile $gambar): int
    {
        $baru = $this->upload($gambar);
        if ($baru) $data['gambar'] = $baru;

        $id = $this->model->insert($data, true);

        if ($id === false) {
            $this->hapusFile($baru); // rollback file yatim
            throw new RuntimeException(
                'Gagal menyimpan kegiatan: ' .
                (implode(', ', $this->model->errors()) ?: 'kesalahan tidak diketahui.')
            );
        }

        return (int) $id;
    }

    public function perbarui(int $id, array $data, ?UploadedFile $gambar): bool
    {
        $kegiatan = $this->cari($id) ?? throw new RuntimeException('Kegiatan tidak ditemukan.');
        $lama     = $kegiatan['gambar'] ?? null;
        $baru     = $this->upload($gambar);

        if ($baru) $data['gambar'] = $baru;

        if (! $this->model->update($id, $data)) {
            $this->hapusFile($baru);
            throw new RuntimeException(
                'Gagal memperbarui kegiatan: ' .
                (implode(', ', $this->model->errors()) ?: 'kesalahan tidak diketahui.')
            );
        }

        if ($baru) $this->hapusFile($lama);
        return true;
    }

    public function hapus(int $id): bool
    {
        $kegiatan = $this->cari($id) ?? throw new RuntimeException('Kegiatan tidak ditemukan.');

        if (! $this->model->delete($id)) {
            throw new RuntimeException('Gagal menghapus kegiatan.');
        }

        $this->hapusFile($kegiatan['gambar'] ?? null);
        return true;
    }

    // ---------------- helpers ----------------

    /** Upload file jika valid; kembalikan nama file baru atau null. */
    private function upload(?UploadedFile $gambar): ?string
    {
        if (! $gambar || ! $gambar->isValid() || $gambar->hasMoved()) return null;

        $folder = WRITEPATH . self::DIR;
        if (! is_dir($folder) && ! mkdir($folder, self::PERM, true) && ! is_dir($folder)) {
            throw new RuntimeException('Folder gambar tidak dapat dibuat.');
        }

        $nama = $gambar->getRandomName();
        if (! $gambar->move($folder, $nama)) {
            throw new RuntimeException('Gagal mengunggah gambar.');
        }
        return $nama;
    }

    /** Hapus file gambar dengan aman (basename mencegah path traversal). */
    private function hapusFile(?string $nama): void
    {
        if (! $nama) return;
        $path = WRITEPATH . self::DIR . basename($nama);
        if (is_file($path)) @unlink($path);
    }
}