use CodeIgniter\Test\CIUnitTestCase;
use App\Models\SiswaModel;

class SiswaTest extends CIUnitTestCase
{
    public function testInsertSiswa()
    {
        $model = new SiswaModel();
        $data = [
            'nama' => 'Ahmad Test',
            'nis' => '998877',
            'kelas_id' => 2,
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
