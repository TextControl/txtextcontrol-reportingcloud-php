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

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

/**
 * Trait AssertTimestampTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTimestampTestTrait
{
    public function testAssertTimestamp(): void
    {
        Assert::assertTimestamp(0);
        Assert::assertTimestamp(1);
        Assert::assertTimestamp(1000);
        Assert::assertTimestamp(10000000);
        Assert::assertTimestamp(PHP_INT_MAX);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Timestamp ("-1") must be in the range [0..9223372036854775807]
     */
    public function testAssertTimestampInvalidTooSmall(): void
    {
        Assert::assertTimestamp(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("-50") - range: [0..9223372036854775807]
     */
    public function testAssertTimestampInvalidWithCustomMessage(): void
    {
        Assert::assertTimestamp(-50, 'Custom error message ("%s") - range: [%d..%d]');
    }
}
