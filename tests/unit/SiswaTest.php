<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\SiswaModel;

class SiswaTest extends CIUnitTestCase
{
    public function testInsertSiswa()
    {
        $model = new SiswaModel();
        $data = [
            'nama_siswa' => 'Ahmad Test',
            'nis' => '998877',
            'id_kelas' => 2,
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '08123456789',
        ];
        $this->assertTrue($model->insert($data) > 0);
    }

    public function testFindSiswa()
    {
        $model = new SiswaModel();
        $siswa = $model->where('nis', '998877')->first();
        $this->assertIsArray($siswa);
        $this->assertEquals('Ahmad Test', $siswa['nama']);
    }
}
