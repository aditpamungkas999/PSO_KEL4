use CodeIgniter\Test\CIUnitTestCase;
use Endroid\QrCode\Builder\Builder;

class QRGeneratorTest extends CIUnitTestCase
{
    public function testGenerateQrCode()
    {
        $qrText = '998877';
        $result = Builder::create()
            ->data($qrText)
            ->build();

        $this->assertNotEmpty($result->getString());
    }
}
