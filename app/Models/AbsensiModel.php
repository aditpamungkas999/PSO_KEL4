<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $allowedFields = ['student_id', 'latitude', 'longitude', 'waktu_presensi'];
}
