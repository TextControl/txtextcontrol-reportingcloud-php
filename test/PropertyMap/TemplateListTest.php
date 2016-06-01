<?php

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\PropertyMap\TemplateList as PropertyMap;

class TemplateListTest extends PHPUnit_Framework_TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testDefault()
    {
        $expected =  [
            "templateName" => "template_name",
            "modified"     => "modified",
            "size"         => "size",
        ];

        $this->assertEquals($expected, $this->propertyMap->getMap());
    }
}
