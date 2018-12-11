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
     * @expectedExceptionMessage Zoom factor must be in the range [1..400]
     */
    public function testAssertZoomFactorInvalidTooSmall()
    {
        Assert::assertZoomFactor(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message - range: [1..400]
     */
    public function testAssertZoomFactorInvalidWithCustomMessage()
    {
        Assert::assertZoomFactor(600, 'Custom error message - range: [%d..%d]');
    }
}
