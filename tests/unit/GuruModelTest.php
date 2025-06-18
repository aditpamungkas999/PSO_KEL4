<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\GuruModel;

class GuruModelTest extends CIUnitTestCase
{
    private function getDummyData($overrides = []): array
    {
        $data = [
            'nuptk' => (string) time() . rand(100, 999), 
            'nama_guru' => 'Guru Test',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Pengujian No. 123',
            'no_hp' => '0811' . rand(10000000, 99999999),
            'unique_code' => uniqid('guru_')
        ];
        return array_merge($data, $overrides);
    }

    public function testInsertGuru()
    {
        $model = new GuruModel();
        $data = $this->getDummyData();
        
        $result = $model->insert($data);
        $this->assertTrue($result > 0);
    }

    public function testFindGuru()
    {
        $model = new GuruModel();
        $data = $this->getDummyData();
        $model->insert($data);

        $guru = $model->where('nuptk', $data['nuptk'])->first();
        
        $this->assertIsArray($guru);
        $this->assertEquals($data['nama_guru'], $guru['nama_guru']);
    }

    public function testUpdateGuru()
    {
        $model = new GuruModel();
        $data = $this->getDummyData();
        $id = $model->insert($data);

        $updatedData = ['nama_guru' => 'Guru Updated'];
        $model->update($id, $updatedData);

        $updatedGuru = $model->find($id);
        $this->assertEquals('Guru Updated', $updatedGuru['nama_guru']);
    }
    
    public function testDeleteGuru()
    {
        $model = new GuruModel();
        $data = $this->getDummyData();
        $id = $model->insert($data);
        
        $this->assertNotNull($model->find($id));

        $model->delete($id);

        $this->assertNull($model->find($id));
    }
}