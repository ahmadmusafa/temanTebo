<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table            = 'pendaftaran';
    protected $primaryKey       = 'id_pendaftaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'kode_pendaftaran',
        'id_kegiatan',
        'nama_lengkap',
        'nama_panggilan',
        'email',
        'no_whatsapp',
        'instagram',
        'instansi',
        'jenis_kelamin',
        'tanggal_lahir',
        'domisili',
        'riwayat_penyakit',
        'data_persyaratan',
        'berkas_persyaratan',
        'jumlah_pembayaran',
        'bukti_pembayaran',
        'status_pembayaran',
        'status_pendaftaran',
        'catatan_admin',
    ];
}
