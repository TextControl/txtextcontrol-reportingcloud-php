<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertPageTestTrait
{
    public function testAssertPage()
    {
        $this->assertNull(Assert::assertPage(1));
        $this->assertNull(Assert::assertPage(2));
        $this->assertNull(Assert::assertPage(PHP_INT_MAX));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Page number must be in the range [1..9223372036854775807]
     */
    public function testAssertPageInvalidTooSmall()
    {
        Assert::assertPage(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message - range: [1..9223372036854775807]
     */
    public function testAssertPageInvalidWithCustomMessage()
    {
        Assert::assertPage(-50, 'Custom error message - range: [%d..%d]');
    }
}
