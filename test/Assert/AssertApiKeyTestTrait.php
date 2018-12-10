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
     * @expectedExceptionMessage "xxxxxxxxxx" is an invalid API key -- too short
     */
    public function testAssertApiKeyInvalidTooShort()
    {
        Assert::assertApiKey('xxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" is an invalid API key -- too long
     */
    public function testAssertApiKeyInvalidTooLong()
    {
        Assert::assertApiKey('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("xxxxxxxxxx")
     */
    public function testAssertApiKeyInvalidWithCustomMessage()
    {
        Assert::assertApiKey('xxxxxxxxxx', 'Custom error message (%s)');
    }
}
