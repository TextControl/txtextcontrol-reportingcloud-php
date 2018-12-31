<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertDocumentExtensionTestTrait
{
    public function testAssertDocumentExtension()
    {
        $this->assertNull(Assert::assertDocumentExtension('./document.doc'));
        $this->assertNull(Assert::assertDocumentExtension('./DOCUMENT.DOC'));

        $this->assertNull(Assert::assertDocumentExtension('../document.doc'));
        $this->assertNull(Assert::assertDocumentExtension('../DOCUMENT.DOC'));

        $this->assertNull(Assert::assertDocumentExtension('/../document.doc'));
        $this->assertNull(Assert::assertDocumentExtension('/../DOCUMENT.DOC'));

        $this->assertNull(Assert::assertDocumentExtension('/path/to/document.doc'));
        $this->assertNull(Assert::assertDocumentExtension('/PATH/TO/DOCUMENT.DOC'));

        $this->assertNull(Assert::assertDocumentExtension('c:\path\to\document.doc'));
        $this->assertNull(Assert::assertDocumentExtension('c:\PATH\TO\DOCUMENT.DOC'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "document.xxx" contains an unsupported document format file extension
     */
    public function testAssertDocumentExtensionInvalid()
    {
        Assert::assertDocumentExtension('document.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("document.xxx")
     */
    public function testAssertDocumentExtensionInvalidWithCustomMessage()
    {
        Assert::assertDocumentExtension('document.xxx', 'Custom error message (%s)');
    }
}
