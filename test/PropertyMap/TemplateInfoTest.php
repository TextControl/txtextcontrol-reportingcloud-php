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
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\PropertyMap;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\PropertyMap\TemplateInfo as PropertyMap;

/**
 * Class TemplateInfoTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TemplateInfoTest extends TestCase
{
    /**
     * @var PropertyMap
     */
    protected $propertyMap;

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
            'dateTimeFormat'         => 'date_time_format',
            'mergeBlocks'            => 'merge_blocks',
            'mergeFields'            => 'merge_fields',
            'name'                   => 'name',
            'numericFormat'          => 'numeric_format',
            'preserveFormatting'     => 'preserve_formatting',
            'templateName'           => 'template_name',
            'text'                   => 'text',
            'textAfter'              => 'text_after',
            'textBefore'             => 'text_before',
            'userDocumentProperties' => 'user_document_properties',
        ];

        self::assertSame($expected, $this->propertyMap->getMap());
    }
}
