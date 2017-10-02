<?php

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\PropertyMap\IncorrectWord as PropertyMap;

class IncorrectWordTest extends PHPUnit_Framework_TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected = [
            'length'      => 'length',
            'start'       => 'start',
            'text'        => 'text',
            'isDuplicate' => 'is_duplicate',
            'language'    => 'language',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
