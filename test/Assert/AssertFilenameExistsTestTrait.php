<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertFilenameExistsTestTrait
{
    public function testAssertFilenameExists()
    {
        $filename = tempnam(sys_get_temp_dir(), md5(__CLASS__));
        touch($filename);
        $this->assertNull(Assert::filenameExists($filename));
        unlink($filename);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/path/to/invalid/file" must contain the absolute path and file
     */
    public function testAssertFilenameExistsInvalidDoesContainAbsolutePathAndFile()
    {
        Assert::filenameExists('/path/to/invalid/file');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/tmp" is not a regular file
     */
    public function testAssertFilenameExistsInvalidIsNotARegularFile()
    {
        Assert::filenameExists('/tmp');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("/path/to/invalid/file")
     */
    public function testAssertFilenameExistsInvalidWithCustomMessage()
    {
        Assert::filenameExists('/path/to/invalid/file', 'Custom error message (%s)');
    }
}
