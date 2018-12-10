<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertPageTestTrait
{
    public function testAssertPage()
    {
        $this->assertNull(Assert::assertPage(250));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage -1 contains an invalid page number
     */
    public function testAssertPageInvalidTooSmall()
    {
        Assert::assertPage(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (600)
     */
    public function testAssertPageInvalidWithCustomMessage()
    {
        Assert::assertPage(-50, 'Custom error message (600)');
    }
}
