<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertDocumentExtensionTestTrait
{
    public function testAssertDocumentExtension()
    {
        $this->assertNull(Assert::assertDocumentExtension('TX'));
        $this->assertNull(Assert::assertDocumentExtension('tx'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxx" contains an unsupported document format file extension
     */
    public function testAssertDocumentExtensionInvalid()
    {
        Assert::assertDocumentExtension('xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (XXX)
     */
    public function testAssertDocumentExtensionInvalidWithCustomMessage()
    {
        Assert::assertDocumentExtension('XXX', 'Custom error message (XXX)');
    }
}
