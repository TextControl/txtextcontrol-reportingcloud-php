<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertApiKeyTestTrait
{
    public function testAssertApiKey()
    {
        $this->assertNull(Assert::assertApiKey('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage API key ("xxxxxxxxxx") must between 20 and 45 characters in length
     */
    public function testAssertApiKeyInvalidTooShort()
    {
        Assert::assertApiKey('xxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage API key ("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx") must between 20 and 45 characters in length
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
