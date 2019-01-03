<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
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
    protected $propertyMap;

    public function setUp()
    {
        $this->propertyMap = new PropertyMap();
    }

    public function testValid()
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

        $this->assertSame($expected, $this->propertyMap->getMap());
    }
}
