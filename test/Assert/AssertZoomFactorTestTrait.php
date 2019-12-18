<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://github.com/TextControl/txtextcontrol-reportingcloud-php/blob/master/LICENSE.md
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

/**
 * Trait AssertZoomFactorTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertZoomFactorTestTrait
{
    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    /**
     * @param string $exception
     */
    abstract public function expectException(string $exception): void;

    /**
     * @param string $message
     */
    abstract public function expectExceptionMessage(string $message): void;

    // </editor-fold>

    public function testAssertZoomFactor(): void
    {
        Assert::assertZoomFactor(250);

        $this->assertTrue(true);
    }

    public function testAssertZoomFactorInvalidTooSmall(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Zoom factor (-1) must be in the range [1..400]');

        Assert::assertZoomFactor(-1);
    }

    public function testAssertZoomFactorInvalidWithCustomMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Custom error message (600) - range: [1..400]');

        Assert::assertZoomFactor(600, 'Custom error message (%1$s) - range: [%2$s..%3$s]');
    }
}
