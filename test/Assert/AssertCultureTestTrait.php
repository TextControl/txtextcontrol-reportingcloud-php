<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertCultureTestTrait
{
    public function testAssertCulture()
    {
        $this->assertNull(Assert::assertCulture('de-DE'));
        $this->assertNull(Assert::assertCulture('fr-FR'));
        $this->assertNull(Assert::assertCulture('en-US'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "de-XX" contains an unsupported culture
     */
    public function testAssertCultureInvalid()
    {
        Assert::assertCulture('de-XX');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (XXX)
     */
    public function testAssertCultureInvalidWithCustomMessage()
    {
        Assert::assertCulture('XXX', 'Custom error message (XXX)');
    }
}
