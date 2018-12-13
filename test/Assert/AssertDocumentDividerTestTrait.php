<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertDocumentDividerTestTrait
{
    public function testAssertDocumentDivider()
    {
        $this->assertNull(Assert::assertDocumentDivider(1));
        $this->assertNull(Assert::assertDocumentDivider(2));
        $this->assertNull(Assert::assertDocumentDivider(3));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage 10 contains an unsupported document divider
     */
    public function testAssertDocumentDividerInvalid()
    {
        Assert::assertDocumentDivider(10);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (-10)
     */
    public function testAssertDocumentDividerInvalidWithCustomMessage()
    {
        Assert::assertDocumentDivider(-10, 'Custom error message (%s)');
    }
}
