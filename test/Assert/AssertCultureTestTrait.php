<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
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
     * @expectedExceptionMessage Custom error message ("xx-XX")
     */
    public function testAssertCultureInvalidWithCustomMessage()
    {
        Assert::assertCulture('xx-XX', 'Custom error message (%s)');
    }
}
