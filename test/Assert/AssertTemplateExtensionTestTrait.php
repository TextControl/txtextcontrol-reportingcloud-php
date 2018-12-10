<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertTemplateExtensionTestTrait
{
    public function testAssertTemplateExtension()
    {
        $this->assertNull(Assert::assertTemplateExtension('DOC'));
        $this->assertNull(Assert::assertTemplateExtension('doc'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxx" contains an unsupported template format file extension
     */
    public function testAssertTemplateExtensionInvalid()
    {
        Assert::assertTemplateExtension('xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (XXX)
     */
    public function testAssertTemplateExtensionInvalidWithCustomMessage()
    {
        Assert::assertTemplateExtension('XXX', 'Custom error message (XXX)');
    }
}
