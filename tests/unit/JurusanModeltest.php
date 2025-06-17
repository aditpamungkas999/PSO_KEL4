<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\JurusanModel;

class JurusanModelTest extends CIUnitTestCase
{

    public function testInsertJurusan()
    {
        $model = model(JurusanModel::class); // Menggunakan factory
        $namaJurusan = 'Test Jurusan ' . time();
        $data = ['jurusan' => $namaJurusan];
        
        $result = $model->insert($data);
        $this->assertTrue($result > 0);
    }

    public function testFindJurusan()
    {
        $model = model(JurusanModel::class); // Menggunakan factory
        $namaJurusan = 'Jurusan Find Test ' . time();
        $model->insert(['jurusan' => $namaJurusan]);

        $jurusan = $model->where('jurusan', $namaJurusan)->first();
        
        $this->assertIsArray($jurusan);
        $this->assertEquals($namaJurusan, $jurusan['jurusan']);
    }

    public function testUpdateJurusan()
    {
        $model = model(JurusanModel::class); // Menggunakan factory
        $data = ['jurusan' => 'Jurusan For Update ' . time()];
        $id = $model->insert($data);

        $updatedData = ['jurusan' => 'Jurusan Updated'];
        $model->update($id, $updatedData);

        $updatedJurusan = $model->find($id);
        $this->assertEquals('Jurusan Updated', $updatedJurusan['jurusan']);
    }
    
    public function testDeleteJurusan()
    {
        $model = model(JurusanModel::class); // Menggunakan factory
        $data = ['jurusan' => 'Jurusan For Delete ' . time()];
        $id = $model->insert($data);
        
        $this->assertNotNull($model->find($id));

        $model->delete($id);

        $this->assertNull($model->find($id));
    }
}