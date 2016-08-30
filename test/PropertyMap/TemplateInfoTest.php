<?php

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\PropertyMap\TemplateInfo as PropertyMap;

class TemplateInfoTest extends PHPUnit_Framework_TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected = [
            'dateTimeFormat'     => 'date_time_format',
            'mergeBlocks'        => 'merge_blocks',
            'mergeFields'        => 'merge_fields',
            'name'               => 'name',
            'numericFormat'      => 'numeric_format',
            'preserveFormatting' => 'preserve_formatting',
            'templateName'       => 'template_name',
            'text'               => 'text',
            'textAfter'          => 'text_after',
            'textBefore'         => 'text_before',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
