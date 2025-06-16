<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use Endroid\QrCode\Builder\Builder;

class QRCodeTest extends CIUnitTestCase
{
    public function testGenerateQRCode()
    {
        $qrText = '998877';
        $result = Builder::create()
            ->data($qrText)
            ->build();

        $this->assertNotEmpty($result->getString());
    }
}
