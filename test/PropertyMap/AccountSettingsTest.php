<?php

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\AccountSettings as PropertyMap;

class AccountSettingsTest extends TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected = [
            'serialNumber'            => 'serial_number',
            'createdDocuments'        => 'created_documents',
            'uploadedTemplates'       => 'uploaded_templates',
            'maxDocuments'            => 'max_documents',
            'maxTemplates'            => 'max_templates',
            'validUntil'              => 'valid_until',
            'proofingTransactions'    => 'proofing_transactions',
            'maxProofingTransactions' => 'max_proofing_transactions',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
