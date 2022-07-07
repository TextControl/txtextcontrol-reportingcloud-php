<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2022 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\DocumentSettings as PropertyMap;

/**
 * Class DocumentSettingsTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class DocumentSettingsTest extends TestCase
{
    protected PropertyMap $propertyMap;

    public function setUp(): void
    {
        $this->propertyMap = new PropertyMap();
    }

    public function tearDown(): void
    {
        unset($this->propertyMap);
    }

    public function testValid(): void
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

        self::assertSame($expected, $this->propertyMap->getMap());
    }
}
