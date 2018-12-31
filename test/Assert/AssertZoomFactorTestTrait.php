<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertZoomFactorTestTrait
{
    public function testAssertZoomFactor()
    {
        $this->assertNull(Assert::assertZoomFactor(250));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Zoom factor (-1) must be in the range [1..400]
     */
    public function testAssertZoomFactorInvalidTooSmall()
    {
        Assert::assertZoomFactor(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (600) - range: [1..400]
     */
    public function testAssertZoomFactorInvalidWithCustomMessage()
    {
        Assert::assertZoomFactor(600, 'Custom error message (%s) - range: [%2$s..%3$s]');
    }
}
