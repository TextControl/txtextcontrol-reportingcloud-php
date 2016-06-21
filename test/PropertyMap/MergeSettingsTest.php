<?php

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\PropertyMap\MergeSettings as PropertyMap;

class MergeSettingsTest extends PHPUnit_Framework_TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected =  [
            'author'                   => 'author',
            'creationDate'             => 'creation_date',
            'creatorApplication'       => 'creator_application',
            'documentSubject'          => 'document_subject',
            'documentTitle'            => 'document_title',
            'lastModificationDate'     => 'last_modification_date',
            'removeEmptyBlocks'        => 'remove_empty_blocks',
            'removeEmptyFields'        => 'remove_empty_fields',
            'removeEmptyImages'        => 'remove_empty_images',
            'removeTrailingWhitespace' => 'remove_trailing_whitespace',
            'userPassword'             => 'user_password',

        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
