<?php

namespace App\Services;

use Config\Database;
use RuntimeException;
use Throwable;

class PendaftaranService
{
    public function setujui(int $id): array
    {
        $db = Database::connect();

        $db->transBegin();

        try {
            // Ambil dan kunci data pendaftaran
            $pendaftaran = $db->query(
                'SELECT * FROM pendaftaran WHERE id_pendaftaran = ? FOR UPDATE',
                [$id]
            )->getRowArray();

            if (!$pendaftaran) {
                throw new RuntimeException('Data pendaftaran tidak ditemukan.');
            }

            if ($pendaftaran['status_pendaftaran'] !== 'menunggu_verifikasi') {
                throw new RuntimeException('Pendaftaran sudah diproses sebelumnya.');
            }

            // Ambil dan kunci data kegiatan
            $kegiatan = $db->query(
                'SELECT * FROM kegiatan WHERE id = ? FOR UPDATE',
                [$pendaftaran['id_kegiatan']]
            )->getRowArray();

            if (!$kegiatan) {
                throw new RuntimeException('Data kegiatan tidak ditemukan.');
            }

            if ((int) $kegiatan['kuota'] < 1) {
                throw new RuntimeException('Kuota kegiatan sudah habis.');
            }

            // Periksa bukti pembayaran
            $berbayar = $kegiatan['jenis_biaya'] === 'berbayar';

            if ($berbayar && empty($pendaftaran['bukti_pembayaran'])) {
                throw new RuntimeException('Bukti pembayaran belum tersedia.');
            }

            // Tentukan status pembayaran
            $statusPembayaran = $berbayar ? 'diterima' : 'tidak_ada';

            // Perbarui status pendaftaran
            $berhasil = $db->table('pendaftaran')
                ->where('id_pendaftaran', $id)
                ->update([
                    'status_pendaftaran' => 'diterima',
                    'status_pembayaran'  => $statusPembayaran,
                ]);

            if (!$berhasil) {
                throw new RuntimeException('Gagal memperbarui pendaftaran.');
            }

            // Kurangi kuota setelah pendaftaran disetujui
            $db->query(
                'UPDATE kegiatan SET kuota = kuota - 1 WHERE id = ? AND kuota > 0',
                [$kegiatan['id']]
            );

            if ($db->affectedRows() !== 1) {
                throw new RuntimeException('Gagal memperbarui kuota kegiatan.');
            }

            if (!$db->transStatus()) {
                throw new RuntimeException('Transaksi database gagal.');
            }

            $db->transCommit();

            return [
                'success' => true,
                'message' => 'Pendaftaran berhasil disetujui.',
            ];
        } catch (Throwable $e) {
            $db->transRollback();

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function tolak(int $id, string $catatan = ''): array
    {
        $db = Database::connect();

        $db->transBegin();

        try {
            // Ambil dan kunci data pendaftaran
            $pendaftaran = $db->query(
                'SELECT * FROM pendaftaran WHERE id_pendaftaran = ? FOR UPDATE',
                [$id]
            )->getRowArray();

            if (!$pendaftaran) {
                throw new RuntimeException('Data pendaftaran tidak ditemukan.');
            }

            if ($pendaftaran['status_pendaftaran'] !== 'menunggu_verifikasi') {
                throw new RuntimeException('Pendaftaran sudah diproses sebelumnya.');
            }

            // Ambil data kegiatan
            $kegiatan = $db->query(
                'SELECT * FROM kegiatan WHERE id = ?',
                [$pendaftaran['id_kegiatan']]
            )->getRowArray();

            if (!$kegiatan) {
                throw new RuntimeException('Data kegiatan tidak ditemukan.');
            }

            $statusPembayaran = $kegiatan['jenis_biaya'] === 'berbayar'
                ? 'ditolak'
                : 'tidak_ada';

            // Perbarui status pendaftaran
            $berhasil = $db->table('pendaftaran')
                ->where('id_pendaftaran', $id)
                ->update([
                    'status_pendaftaran' => 'ditolak',
                    'status_pembayaran'  => $statusPembayaran,
                    'catatan_admin'      => $catatan,
                ]);

            if (!$berhasil || !$db->transStatus()) {
                throw new RuntimeException('Gagal menolak pendaftaran.');
            }

            $db->transCommit();

            return [
                'success' => true,
                'message' => 'Pendaftaran berhasil ditolak.',
            ];
        } catch (Throwable $e) {
            $db->transRollback();

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
