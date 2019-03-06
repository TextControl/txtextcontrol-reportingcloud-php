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
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Assert;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

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
    use FilenameExistsTestTrait;

    public function testOneOf(): void
    {
        Assert::oneOf('a', ['a', 'b', 'c',]);
        Assert::oneOf(1, [1, 2, 3,]);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected one of "a", "b", "c". Got "d"
     */
    public function testOneOfWithInvalidValue(): void
    {
        Assert::oneOf('d', ['a', 'b', 'c',]);
    }

    public function testRange(): void
    {
        Assert::range(5, 1, 10);
        Assert::range(1, 1, 10);
        Assert::range(10, 1, 10);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a value between "1" and "10". Got: "11"
     */
    public function testRangeWithInvalidValue(): void
    {
        Assert::range(11, 1, 10);
    }
}
