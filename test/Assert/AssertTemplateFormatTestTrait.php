<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertTemplateFormatTestTrait
{
    public function testAssertTemplateFormat()
    {
        $this->assertNull(Assert::assertTemplateFormat('DOC'));
        $this->assertNull(Assert::assertTemplateFormat('doc'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxx" contains an unsupported template format file extension
     */
    public function testAssertTemplateFormatInvalid()
    {
        Assert::assertTemplateFormat('xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("XXX")
     */
    public function testAssertTemplateFormatInvalidWithCustomMessage()
    {
        Assert::assertTemplateFormat('XXX', 'Custom error message (%s)');
    }
}
