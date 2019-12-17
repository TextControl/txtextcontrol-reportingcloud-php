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

namespace TxTextControlTest\ReportingCloud\Assert;

use PHPUnit\Framework\TestCase;
use stdClass;
use TxTextControlTest\ReportingCloud\Assert\TestAsset\ConcreteAssert as Assert;

/**
 * Class AssertTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class AssertTest extends TestCase
{
    use AssertApiKeyTestTrait;
    use AssertBase64DataTestTrait;
    use AssertBaseUriTestTrait;
    use AssertCultureTestTrait;
    use AssertDateTimeTestTrait;
    use AssertDocumentDividerTestTrait;
    use AssertDocumentExtensionTestTrait;
    use AssertDocumentThumbnailExtensionTestTrait;
    use AssertImageFormatTestTrait;
    use AssertLanguageTestTrait;
    use AssertPageTestTrait;
    use AssertReturnFormatTestTrait;
    use AssertTemplateExtensionTestTrait;
    use AssertTemplateFormatTestTrait;
    use AssertTemplateNameTestTrait;
    use AssertTimestampTestTrait;
    use AssertZoomFactorTestTrait;
    use AssertFilenameExistsTestTrait;
    use AssertOneOfTraitTest;
    use AssertRangeTraitTest;
    use AssertArrayTraitTest;
    use AssertStringTraitTest;
    use AssertIntegerTraitTest;
    use AssertBooleanTraitTest;

    public function testValueToStringNull(): void
    {
        $expected = 'null';
        $actual   = Assert::publicValueToString(null);
        $this->assertEquals($expected, $actual);
    }

    public function testValueToStringTrue(): void
    {
        $expected = 'true';
        $actual   = Assert::publicValueToString(true);
        $this->assertEquals($expected, $actual);
    }

    public function testValueToStringFalse(): void
    {
        $expected = 'false';
        $actual   = Assert::publicValueToString(false);
        $this->assertEquals($expected, $actual);
    }

    public function testValueToStringArray(): void
    {
        $expected = 'array';
        $actual   = Assert::publicValueToString([1, 2, 3]);
        $this->assertEquals($expected, $actual);
    }

    public function testValueToStringObject(): void
    {
        $stdClass = new stdClass();

        $expected = get_class($stdClass);
        $actual   = Assert::publicValueToString($stdClass);

        $this->assertEquals($expected, $actual);
    }

    public function testValueToStringObjectWithToString(): void
    {
        $stdClass = new class extends stdClass
        {
            public function __toString(): string
            {
                return 'abc';
            }
        };

        $expected = sprintf('%1$s: %2$s', get_class($stdClass), Assert::publicValueToString($stdClass->__toString()));
        $actual   = Assert::publicValueToString($stdClass);

        $this->assertEquals($expected, $actual);
    }

    public function testValueToStringResource(): void
    {
        $handle = fopen(__FILE__, 'r');

        $expected = 'resource';
        $actual   = Assert::publicValueToString($handle);

        $this->assertEquals($expected, $actual);
    }

    public function testValueToStringString(): void
    {
        $expected = '"abc"';
        $actual   = Assert::publicValueToString('abc');
        $this->assertEquals($expected, $actual);
    }
}
