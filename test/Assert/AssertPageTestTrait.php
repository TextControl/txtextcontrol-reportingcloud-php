<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
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
     * @expectedExceptionMessage Page number (-1) must be in the range [1..9223372036854775807]
     */
    public function testAssertPageInvalidTooSmall()
    {
        Assert::assertPage(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (-50) - range: [1..9223372036854775807]
     */
    public function testAssertPageInvalidWithCustomMessage()
    {
        Assert::assertPage(-50, 'Custom error message (%s) - range: [%2$s..%3$s]');
    }
}
