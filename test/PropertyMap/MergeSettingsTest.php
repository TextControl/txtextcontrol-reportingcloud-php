<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\MergeSettings as PropertyMap;

/**
 * Class MergeSettingsTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class MergeSettingsTest extends TestCase
{
    /**
     * @var PropertyMap
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $propertyMap;

    public function setUp(): void
    {
        $this->propertyMap = new PropertyMap();
    }

    public function tearDown(): void
    {
        // $this->propertyMap = null;
    }

    public function testValid(): void
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
