<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertTimestampTestTrait
{
    public function testAssertTimestamp()
    {
        $this->assertNull(Assert::assertTimestamp(0));
        $this->assertNull(Assert::assertTimestamp(1));
        $this->assertNull(Assert::assertTimestamp(1000));
        $this->assertNull(Assert::assertTimestamp(10000000));
        $this->assertNull(Assert::assertTimestamp(PHP_INT_MAX));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Timestamp (-1) must be in the range [0..9223372036854775807]
     */
    public function testAssertTimestampInvalidTooSmall()
    {
        Assert::assertTimestamp(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (-50) - range: [0..9223372036854775807]
     */
    public function testAssertTimestampInvalidWithCustomMessage()
    {
        Assert::assertTimestamp(-50, 'Custom error message (%s) - range: [%2$s..%3$s]');
    }
}
