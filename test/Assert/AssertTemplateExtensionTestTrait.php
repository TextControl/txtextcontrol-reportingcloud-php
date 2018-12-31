<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertTemplateExtensionTestTrait
{
    public function testAssertTemplateExtension()
    {
        $this->assertNull(Assert::assertTemplateExtension('./template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('./TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('../template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('../TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('/../template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('/../TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('/path/to/template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('/PATH/TO/TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('c:\path\to\template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('c:\PATH\TO\TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('.tx'));
        $this->assertNull(Assert::assertTemplateExtension('.TX'));

        $this->assertNull(Assert::assertTemplateExtension('1.tx'));
        $this->assertNull(Assert::assertTemplateExtension('1.TX'));

        $this->assertNull(Assert::assertTemplateExtension('a.tx'));
        $this->assertNull(Assert::assertTemplateExtension('A.TX'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "template.xxx" contains an unsupported template format file extension
     */
    public function testAssertTemplateExtensionInvalid()
    {
        Assert::assertTemplateExtension('template.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("template.xxx")
     */
    public function testAssertTemplateExtensionInvalidWithCustomMessage()
    {
        Assert::assertTemplateExtension('template.xxx', 'Custom error message (%s)');
    }
}
