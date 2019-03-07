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

    // </editor-fold>

    public function testAssertFilenameExists(): void
    {
        $filename = (string) tempnam(sys_get_temp_dir(), hash('sha256', __CLASS__));
        touch($filename);
        Assert::assertFilenameExists($filename);
        unlink($filename);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/path/to/invalid/file" does not exist or is not readable
     */
    public function testAssertFilenameExistsInvalidDoesContainAbsolutePathAndFile(): void
    {
        Assert::assertFilenameExists('/path/to/invalid/file');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/tmp" is not a regular file
     */
    public function testAssertFilenameExistsInvalidIsNotARegularFile(): void
    {
        Assert::assertFilenameExists('/tmp');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("/path/to/invalid/file")
     */
    public function testAssertFilenameExistsInvalidWithCustomMessage(): void
    {
        Assert::assertFilenameExists('/path/to/invalid/file', 'Custom error message (%1$s)');
    }
}
