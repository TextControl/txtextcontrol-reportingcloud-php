<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertTemplateNameTestTrait
{
    public function testAssertTemplateName()
    {
        $this->assertNull(Assert::assertTemplateName('template.tx'));
        $this->assertNull(Assert::assertTemplateName('template.TX'));
        $this->assertNull(Assert::assertTemplateName('TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateName('template.doc'));
        $this->assertNull(Assert::assertTemplateName('template.DOC'));
        $this->assertNull(Assert::assertTemplateName('TEMPLATE.DOC'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/path/to/template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidAbsolutePath()
    {
        Assert::assertTemplateName('/path/to/template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "/../template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidDirectoryTraversal1()
    {
        Assert::assertTemplateName('/../template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "../template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidDirectoryTraversal2()
    {
        Assert::assertTemplateName('../template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "./template.tx" contains path information ('/', '.', or '..')
     */
    public function testAssertTemplateNameInvalidPath4()
    {
        Assert::assertTemplateName('./template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("invalid.xxx")
     */
    public function testAssertTemplateNameInvalidWithCustomMessage()
    {
        Assert::assertTemplateName('invalid.xxx', 'Custom error message (%s)');
    }
}
