<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\MergeSettings as PropertyMap;

class MergeSettingsTest extends TestCase
{
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
    {
        $expected = [
            'author'                   => 'author',
            'creationDate'             => 'creation_date',
            'creatorApplication'       => 'creator_application',
            'culture'                  => 'culture',
            'documentSubject'          => 'document_subject',
            'documentTitle'            => 'document_title',
            'lastModificationDate'     => 'last_modification_date',
            'mergeHtml'                => 'merge_html',
            'removeEmptyBlocks'        => 'remove_empty_blocks',
            'removeEmptyFields'        => 'remove_empty_fields',
            'removeEmptyImages'        => 'remove_empty_images',
            'removeTrailingWhitespace' => 'remove_trailing_whitespace',
            'userPassword'             => 'user_password',
        ];

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
