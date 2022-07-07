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

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait AssertFilenameExistsTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertFilenameExistsTestTrait
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

    public function testAssertFilenameExists(): void
    {
        $filename = (string) tempnam(sys_get_temp_dir(), hash('sha256', __CLASS__));
        touch($filename);
        Assert::assertFilenameExists($filename);
        unlink($filename);

        self::assertTrue(true);
    }

    public function testAssertFilenameExistsInvalidDoesContainAbsolutePathAndFile(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"/path/to/invalid/file" does not exist or is not readable');

        Assert::assertFilenameExists('/path/to/invalid/file');
    }

    public function testAssertFilenameExistsInvalidIsNotARegularFile(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"/tmp" is not a regular file');

        Assert::assertFilenameExists('/tmp');
    }

    public function testAssertFilenameExistsInvalidWithCustomMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Custom error message ("/path/to/invalid/file")');

        Assert::assertFilenameExists('/path/to/invalid/file', 'Custom error message (%1$s)');
    }
}
