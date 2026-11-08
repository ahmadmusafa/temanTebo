<?php

namespace App\Models;

use CodeIgniter\Model;

class StatistikModel extends Model
{
    protected $table            = 'statistik';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'relawan',
        'organisasi',
        'aktivitas_sosial',
    ];

    protected $useTimestamps = false;
}