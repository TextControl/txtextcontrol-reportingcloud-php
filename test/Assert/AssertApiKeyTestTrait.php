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
     * @expectedExceptionMessage API key must between 20 and 45 characters in length
     */
    public function testAssertApiKeyInvalidTooShort()
    {
        Assert::assertApiKey('xxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage API key must between 20 and 45 characters in length
     */
    public function testAssertApiKeyInvalidTooLong()
    {
        Assert::assertApiKey('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid length. Got 20
     */
    public function testAssertApiKeyInvalidWithCustomMessage()
    {
        Assert::assertApiKey('xxxxxxxxxx', 'Invalid length. Got %d');
    }
}
