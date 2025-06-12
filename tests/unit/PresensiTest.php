use CodeIgniter\Test\CIUnitTestCase;
use App\Models\PresensiModel;

class PresensiTest extends CIUnitTestCase
{
    public function testValidQRCodePresensi()
    {
        $model = new PresensiModel();
        $qrData = '998877'; // Misal ini NIS siswa
        
        $result = $model->catatPresensi($qrData); // fungsi buatan kamu
        $this->assertTrue($result);
    }
}
