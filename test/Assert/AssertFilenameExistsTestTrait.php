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
    public function testAssertFilenameExists(): void
    {
        $filename = (string) tempnam(sys_get_temp_dir(), hash('sha256', __CLASS__));
        touch($filename);
        Assert::filenameExists($filename);
        unlink($filename);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/path/to/invalid/file" must contain the absolute path and file
     */
    public function testAssertFilenameExistsInvalidDoesContainAbsolutePathAndFile(): void
    {
        Assert::filenameExists('/path/to/invalid/file');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/tmp" is not a regular file
     */
    public function testAssertFilenameExistsInvalidIsNotARegularFile(): void
    {
        Assert::filenameExists('/tmp');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("/path/to/invalid/file")
     */
    public function testAssertFilenameExistsInvalidWithCustomMessage(): void
    {
        Assert::filenameExists('/path/to/invalid/file', 'Custom error message ("%s")');
    }
}
