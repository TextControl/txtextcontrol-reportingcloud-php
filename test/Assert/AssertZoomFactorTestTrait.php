<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertZoomFactorTestTrait
{
    public function testAssertZoomFactor()
    {
        $this->assertNull(Assert::assertZoomFactor(250));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage -1 is an invalid zoom factor -- too small
     */
    public function testAssertZoomFactorInvalidTooSmall()
    {
        Assert::assertZoomFactor(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (600)
     */
    public function testAssertZoomFactorInvalidWithCustomMessage()
    {
        Assert::assertZoomFactor(600, 'Custom error message (600)');
    }
}
