<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\KelasModel;
use App\Models\JurusanModel;

class KelasModelTest extends CIUnitTestCase
{
    // Helper untuk memastikan ada Jurusan di database
    private function getJurusanId(): int
    {
        $jurusanModel = new JurusanModel();
        $jurusan = $jurusanModel->first();
        if (!$jurusan) {
            // PERBAIKAN: Menggunakan nama kolom 'nama_jurusan' yang benar
            return $jurusanModel->insert(['jurusan' => 'Jurusan Default Test ' . time()]);
        }
        return $jurusan['id'];
    }

    public function testInsertKelas()
    {
        $model = new KelasModel();
        $jurusanId = $this->getJurusanId();

        $data = [
            
            'kelas' => 'Test Kelas ' . time(),
            'id_jurusan' => $jurusanId
        ];
        
        $result = $model->insert($data);
        $this->assertTrue($result > 0);
    }

    public function testFindKelas()
    {
        $model = new KelasModel();
        $jurusanId = $this->getJurusanId();
        $namaKelas = 'Kelas Find Test ' . time();
        
        // PERBAIKAN: Menggunakan nama kolom 'nama_kelas' yang benar
        $data = ['kelas' => $namaKelas, 'id_jurusan' => $jurusanId];
        $model->insert($data);

        // PERBAIKAN: Mencari berdasarkan 'nama_kelas'
        $kelas = $model->where('kelas', $namaKelas)->first();
        
        $this->assertIsArray($kelas);
        // PERBAIKAN: Membandingkan dengan 'nama_kelas'
        $this->assertEquals($namaKelas, $kelas['kelas']);
    }

    public function testUpdateKelas()
    {
        $model = new KelasModel();
        $jurusanId = $this->getJurusanId();
        // PERBAIKAN: Menggunakan nama kolom 'nama_kelas' yang benar
        $data = ['kelas' => 'Kelas For Update ' . time(), 'id_jurusan' => $jurusanId];
        $id = $model->insert($data);

        // PERBAIKAN: Menggunakan nama kolom 'nama_kelas' yang benar
        $updatedData = ['kelas' => 'Kelas Updated'];
        $model->update($id, $updatedData);

        $updatedKelas = $model->find($id);
        // PERBAIKAN: Membandingkan dengan 'nama_kelas'
        $this->assertEquals('Kelas Updated', $updatedKelas['kelas']);
    }
    
    public function testDeleteKelas()
    {
        $model = new KelasModel();
        $jurusanId = $this->getJurusanId();
        // PERBAIKAN: Menggunakan nama kolom 'nama_kelas' yang benar
        $data = ['kelas' => 'Kelas For Delete ' . time(), 'id_jurusan' => $jurusanId];
        $id = $model->insert($data);
        
        $this->assertNotNull($model->find($id));

        $model->delete($id);

        $this->assertNull($model->find($id));
    }
}