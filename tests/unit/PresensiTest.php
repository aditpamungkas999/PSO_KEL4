<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\AbsensiModel;

class PresensiTest extends CIUnitTestCase
{
    public function testValidQRCodePresensi()
    {
        $model = new AbsensiModel();

        $data = [
            'student_id' => '998877',
            'latitude' => '1.23', // kamu bisa pakai dummy
            'longitude' => '4.56',
            'waktu_presensi' => date('Y-m-d H:i:s'),
        ];

        $result = $model->insert($data);

        $this->assertIsInt($result); // insert() akan mengembalikan ID jika berhasil
        $this->assertGreaterThan(0, $result);
    }
}
