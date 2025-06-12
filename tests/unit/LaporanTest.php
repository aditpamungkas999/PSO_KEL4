use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\LaporanPDF;

class LaporanTest extends CIUnitTestCase
{
    public function testGenerateLaporanPDF()
    {
        $laporan = new LaporanPDF();
        $filePath = WRITEPATH . 'laporan/test_laporan.pdf';
        $result = $laporan->generate($filePath); // asumsi kamu buat fungsi ini

        $this->assertFileExists($filePath);
    }
}
