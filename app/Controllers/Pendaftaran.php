<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PendaftaranModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pendaftaran extends BaseController
{
    protected KegiatanModel $kegiatanModel;
    protected PendaftaranModel $pendaftaranModel;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanModel();
        $this->pendaftaranModel = new PendaftaranModel();
    }

    public function simpan()
    {
        $kirimJson = function (bool $status, string $message, array $data = []) {
            return $this->response->setJSON(array_merge([
                'status'   => $status,
                'message'  => $message,
                'csrfHash' => csrf_hash(),
            ], $data));
        };

        // Ambil data dari form
        $data = [
            'id_kegiatan'   => $this->request->getPost('id_kegiatan'),
            'nama_lengkap'  => trim((string) $this->request->getPost('nama_lengkap')),
            'nama_panggilan'=> trim((string) $this->request->getPost('nama_panggilan')),
            'email'         => trim((string) $this->request->getPost('email')),
            'no_whatsapp'   => trim((string) $this->request->getPost('no_whatsapp')),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir') ?: null,
            'domisili'      => trim((string) $this->request->getPost('domisili')),
            'instansi'      => trim((string) $this->request->getPost('instansi')),
        ];

        // Sesuaikan nilai radio/select L dan P dengan ENUM database
        $data['jenis_kelamin'] = match ($data['jenis_kelamin']) {
            'L', 'Laki-laki' => 'Laki-laki',
            'P', 'Perempuan' => 'Perempuan',
            default => '',
        };

        // Validasi data peserta
        $rules = [
            'id_kegiatan'  => 'required|integer',
            'nama_lengkap' => 'required|min_length[3]|max_length[150]',
            'nama_panggilan' => 'permit_empty|max_length[100]',
            'email'        => 'required|valid_email|max_length[150]',
            'no_whatsapp'  => 'required|min_length[8]|max_length[20]',
            'jenis_kelamin'=> 'required|in_list[Laki-laki,Perempuan]',
            'tanggal_lahir'=> 'permit_empty|valid_date[Y-m-d]',
            'domisili'     => 'permit_empty|max_length[150]',
            'instansi'     => 'permit_empty|max_length[150]',
        ];

        if (! $this->validateData($data, $rules)) {
            return $kirimJson(false, 'Periksa kembali data yang kamu masukkan.', [
                'errors' => $this->validator->getErrors(),
            ]);
        }

        // Cari kegiatan
        $kegiatan = $this->kegiatanModel->find((int) $data['id_kegiatan']);

        if (! $kegiatan || ! $kegiatan['aktif']) {
            return $kirimJson(false, 'Kegiatan tidak ditemukan atau tidak aktif.');
        }

        // Periksa batas pendaftaran
        if (
            ! empty($kegiatan['batas_pendaftaran'])
            && strtotime($kegiatan['batas_pendaftaran']) < strtotime(date('Y-m-d'))
        ) {
            return $kirimJson(false, 'Pendaftaran kegiatan sudah ditutup.');
        }

        // Periksa kuota
        if ((int) $kegiatan['kuota'] <= 0) {
            return $kirimJson(false, 'Kuota peserta kegiatan sudah penuh.');
        }

        // Cegah email yang sama mendaftar berkali-kali pada kegiatan yang sama
        $sudahMendaftar = $this->pendaftaranModel
            ->where('id_kegiatan', $data['id_kegiatan'])
            ->where('email', $data['email'])
            ->first();

        if ($sudahMendaftar) {
            return $kirimJson(false, 'Email ini sudah terdaftar pada kegiatan tersebut.');
        }

        // Periksa jenis biaya
        $berbayar = $kegiatan['jenis_biaya'] === 'berbayar';

        $jumlahPembayaran = $berbayar
            ? (float) $kegiatan['biaya_pendaftaran']
            : 0;

        $namaBukti = null;

        // Upload bukti pembayaran jika kegiatan berbayar
        if ($berbayar) {
            $file = $this->request->getFile('bukti_pembayaran');

            if (! $file || ! $file->isValid()) {
                return $kirimJson(false, 'Bukti pembayaran wajib diunggah.');
            }

            $aturanFile = [
                'bukti_pembayaran' => [
                    'label' => 'Bukti pembayaran',
                    'rules' => [
                        'uploaded[bukti_pembayaran]',
                        'max_size[bukti_pembayaran,2048]',
                        'ext_in[bukti_pembayaran,jpg,jpeg,png,pdf]',
                        'mime_in[bukti_pembayaran,image/jpeg,image/png,application/pdf]',
                    ],
                ],
            ];

            if (! $this->validateData([], $aturanFile)) {
                return $kirimJson(false, 'Bukti pembayaran tidak valid.', [
                    'errors' => $this->validator->getErrors(),
                ]);
            }

            $folder = WRITEPATH . 'uploads/bukti_pembayaran/';

            if (! is_dir($folder)) {
                mkdir($folder, 0755, true);
            }

            $namaBukti = $file->getRandomName();

            if (! $file->move($folder, $namaBukti)) {
                return $kirimJson(false, 'Gagal mengunggah bukti pembayaran.');
            }
        }

        // Buat kode pendaftaran
        $kodePendaftaran = 'REG-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));

        // Simpan pendaftaran
        $dataSimpan = [
            'kode_pendaftaran'  => $kodePendaftaran,
            'id_kegiatan'       => $data['id_kegiatan'],
            'nama_lengkap'      => $data['nama_lengkap'],
            'nama_panggilan'    => $data['nama_panggilan'] ?: null,
            'email'             => $data['email'],
            'no_whatsapp'       => $data['no_whatsapp'],
            'jenis_kelamin'     => $data['jenis_kelamin'],
            'tanggal_lahir'     => $data['tanggal_lahir'],
            'domisili'          => $data['domisili'] ?: null,
            'instansi'          => $data['instansi'] ?: null,
            'jumlah_pembayaran' => $jumlahPembayaran,
            'bukti_pembayaran'  => $namaBukti,
            'status_pembayaran' => 'menunggu_verifikasi',
            'status_pendaftaran'=> 'menunggu_verifikasi',
        ];

        if (! $this->pendaftaranModel->insert($dataSimpan)) {
            // Hapus file jika penyimpanan database gagal
            if ($namaBukti && is_file($folder . $namaBukti)) {
                unlink($folder . $namaBukti);
            }

            return $kirimJson(false, 'Pendaftaran gagal disimpan.', [
                'errors' => $this->pendaftaranModel->errors(),
            ]);
        }

        return $kirimJson(true, 'Pendaftaran berhasil dikirim. Silakan tunggu verifikasi admin.', [
            'kode_pendaftaran' => $kodePendaftaran,
        ]);
    }
}
