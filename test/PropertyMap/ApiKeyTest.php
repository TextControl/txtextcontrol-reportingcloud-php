<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\ApiKey as PropertyMap;

class ApiKeyTest extends TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected = [
            'key'    => 'key',
            'active' => 'active',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
