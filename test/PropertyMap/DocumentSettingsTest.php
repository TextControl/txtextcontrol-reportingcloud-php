<?php

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\DocumentSettings as PropertyMap;

class DocumentSettingsTest extends TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected = [
            'author'               => 'author',
            'creationDate'         => 'creation_date',
            'creatorApplication'   => 'creator_application',
            'documentSubject'      => 'document_subject',
            'documentTitle'        => 'document_title',
            'lastModificationDate' => 'last_modification_date',
            'userPassword'         => 'user_password',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
