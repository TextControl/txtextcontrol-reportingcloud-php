<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertImageFormatTestTrait
{
    public function testAssertImageFormat()
    {
        $this->assertNull(Assert::assertImageFormat('PNG'));
        $this->assertNull(Assert::assertImageFormat('png'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxx" contains an unsupported image format file extension
     */
    public function testAssertImageFormatInvalid()
    {
        Assert::assertImageFormat('xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (XXX)
     */
    public function testAssertImageFormatInvalidWithCustomMessage()
    {
        Assert::assertImageFormat('XXX', 'Custom error message (XXX)');
    }
}
