<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
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
     * @expectedExceptionMessage Custom error message ("SVG")
     */
    public function testAssertImageFormatInvalidWithCustomMessage()
    {
        Assert::assertImageFormat('SVG', 'Custom error message (%s)');
    }
}
