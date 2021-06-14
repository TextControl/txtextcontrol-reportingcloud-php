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

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

/**
 * Trait AssertDateTimeTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertDateTimeTestTrait
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

    public function testAssertDateTime(): void
    {
        Assert::assertDateTime('2016-06-02T15:49:57+00:00');
        Assert::assertDateTime('1980-06-02T15:49:57+00:00');

        $this->assertTrue(true);
    }

    public function testAssertDateTimeInvalidLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"2016-06-02T15:49:57+00:00:00" has an invalid number of characters in it');

        Assert::assertDateTime('2016-06-02T15:49:57+00:00:00');
    }

    public function testAssertDateTimeInvalidSyntax(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"xxxx-06-02T15:49:57+00:00" is syntactically invalid');

        Assert::assertDateTime('xxxx-06-02T15:49:57+00:00');
    }

    public function testAssertDateTimeInvalidOffset(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"2016-06-02T15:49:57+02:00" has an invalid offset');

        Assert::assertDateTime('2016-06-02T15:49:57+02:00');
    }

    public function testAssertDateTimeInvalidWithCustomMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Custom error message ("0000-00-00T00:00:00+xx:xx")');

        Assert::assertDateTime('0000-00-00T00:00:00+xx:xx', 'Custom error message (%1$s)');
    }
}
