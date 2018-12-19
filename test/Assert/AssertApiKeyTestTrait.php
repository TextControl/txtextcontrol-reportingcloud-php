<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertApiKeyTestTrait
{
    public function testAssertApiKey()
    {
        $this->assertNull(Assert::assertApiKey('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Length of API key ("xxxxxxxxxx") must be in the range [20..45]
     */
    public function testAssertApiKeyInvalidTooShort()
    {
        Assert::assertApiKey('xxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Length of API key ("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx") must be in
     * the range [20..45]
     */
    public function testAssertApiKeyInvalidTooLong()
    {
        Assert::assertApiKey('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid length: ("xxxxxxxxxx") must be in the range [20..45]
     */
    public function testAssertApiKeyInvalidWithCustomMessage()
    {
        Assert::assertApiKey('xxxxxxxxxx', 'Invalid length: (%s) must be in the range [%2$s..%3$s]');
    }
}
