<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertDateTimeTestTrait
{
    public function testAssertDateTime()
    {
        $this->assertNull(Assert::assertDateTime('2016-06-02T15:49:57+00:00'));
        $this->assertNull(Assert::assertDateTime('1980-06-02T15:49:57+00:00'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "2016-06-02T15:49:57+00:00:00" has an invalid number of characters in it
     */
    public function testAssertDateTimeInvalidLength()
    {
        Assert::assertDateTime('2016-06-02T15:49:57+00:00:00');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxxx-06-02T15:49:57+00:00" is syntactically invalid
     */
    public function testAssertDateTimeInvalidSyntax()
    {
        Assert::assertDateTime('xxxx-06-02T15:49:57+00:00');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "2016-06-02T15:49:57+02:00" has an invalid offset
     */
    public function testAssertDateTimeInvalidOffset()
    {
        Assert::assertDateTime('2016-06-02T15:49:57+02:00');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("0000-00-00T00:00:00+xx:xx")
     */
    public function testAssertDateTimeInvalidWithCustomMessage()
    {
        Assert::assertDateTime('0000-00-00T00:00:00+xx:xx', 'Custom error message (%s)');
    }
}
