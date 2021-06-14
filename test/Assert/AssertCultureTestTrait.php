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
 * Trait AssertCultureTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertCultureTestTrait
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

    public function testAssertCulture(): void
    {
        Assert::assertCulture('de-DE');
        Assert::assertCulture('fr-FR');
        Assert::assertCulture('en-US');

        $this->assertTrue(true);
    }

    public function testAssertCultureInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"de-XX" contains an unsupported culture');

        Assert::assertCulture('de-XX');
    }

    public function testAssertCultureInvalidWithCustomMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Custom error message ("xx-XX")');

        Assert::assertCulture('xx-XX', 'Custom error message (%1$s)');
    }
}
