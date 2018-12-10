<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertFilenameExistsTestTrait
{
    public function testAssertFilenameExists()
    {
        $filename = tempnam(sys_get_temp_dir(), md5(__CLASS__));
        touch($filename);
        $this->assertNull(Assert::assertFilenameExists($filename));
        unlink($filename);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/path/to/invalid/file" contains an invalid filename
     */
    public function testAssertFilenameExistsInvalid()
    {
        Assert::assertFilenameExists('/path/to/invalid/file');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("/path/to/invalid/file")
     */
    public function testAssertFilenameExistsInvalidWithCustomMessage()
    {
        Assert::assertFilenameExists('/path/to/invalid/file', 'Custom error message (%s)');
    }
}
