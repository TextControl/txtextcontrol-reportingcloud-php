<?php

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\PropertyMap\AccountSettings as PropertyMap;

class AccountSettingsTest extends PHPUnit_Framework_TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected =  [
            'serialNumber'      => 'serial_number',
            'createdDocuments'  => 'created_documents',
            'uploadedTemplates' => 'uploaded_templates',
            'maxDocuments'      => 'max_documents',
            'maxTemplates'      => 'max_templates',
            'validUntil'        => 'valid_until',
        ];

        $this->assertEquals($expected, $this->propertyMap->getMap());
    }
}
