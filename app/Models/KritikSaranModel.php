<?php

namespace App\Models;

use CodeIgniter\Model;

class KritikSaranModel extends Model
{
    protected $table            = 'kritik_saran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'email', 'jenis', 'pesan'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nama'  => 'required|min_length[3]|max_length[100]',
        'email' => 'permit_empty|valid_email|max_length[150]',
        'jenis' => 'required|in_list[kritik,saran]',
        'pesan' => 'required|min_length[10]|max_length[1000]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
            'max_length' => 'Nama maksimal 100 karakter.',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
            'max_length'  => 'Email maksimal 150 karakter.',
        ],
        'jenis' => [
            'required' => 'Pilih jenis masukan.',
            'in_list'  => 'Jenis masukan tidak valid.',
        ],
        'pesan' => [
            'required'   => 'Pesan wajib diisi.',
            'min_length' => 'Pesan minimal 10 karakter.',
            'max_length' => 'Pesan maksimal 1000 karakter.',
        ],
    ];

    protected $skipValidation = false;
}