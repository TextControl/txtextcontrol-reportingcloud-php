<?php

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\TemplateList as PropertyMap;

class TemplateListTest extends TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected = [
            'templateName' => 'template_name',
            'modified'     => 'modified',
            'size'         => 'size',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
