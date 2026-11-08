<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table            = 'kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'judul',
        'kategori',
        'tanggal',
        'jam',
        'lokasi',
        'deskripsi',
        'gambar',
        'kuota',
        'batas_pendaftaran',
        'jenis_biaya',
        'biaya_pendaftaran',
        'status_pendaftaran',
        'aktif',
    ];
}
