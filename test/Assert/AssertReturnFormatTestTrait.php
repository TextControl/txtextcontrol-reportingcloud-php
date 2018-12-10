<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertReturnFormatTestTrait
{
    public function testAssertReturnFormat()
    {
        $this->assertNull(Assert::assertReturnFormat('DOC'));
        $this->assertNull(Assert::assertReturnFormat('doc'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxx" contains an unsupported return format file extension
     */
    public function testAssertReturnFormatInvalid()
    {
        Assert::assertReturnFormat('xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (XXX)
     */
    public function testAssertReturnFormatInvalidWithCustomMessage()
    {
        Assert::assertReturnFormat('XXX', 'Custom error message (XXX)');
    }
}
