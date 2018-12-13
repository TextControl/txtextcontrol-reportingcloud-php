<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertReturnFormatTestTrait
{
    public function testAssertReturnFormat()
    {
        $this->assertNull(Assert::assertReturnFormat('DOC'));
        $this->assertNull(Assert::assertReturnFormat('doc'));

        $this->assertNull(Assert::assertReturnFormat('DOCX'));
        $this->assertNull(Assert::assertReturnFormat('docx'));

        $this->assertNull(Assert::assertReturnFormat('HTML'));
        $this->assertNull(Assert::assertReturnFormat('html'));

        $this->assertNull(Assert::assertReturnFormat('PDF'));
        $this->assertNull(Assert::assertReturnFormat('pdf'));

        $this->assertNull(Assert::assertReturnFormat('PDFA'));
        $this->assertNull(Assert::assertReturnFormat('pdfa'));

        $this->assertNull(Assert::assertReturnFormat('RTF'));
        $this->assertNull(Assert::assertReturnFormat('rtf'));

        $this->assertNull(Assert::assertReturnFormat('TX'));
        $this->assertNull(Assert::assertReturnFormat('tx'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxx" contains an unsupported return format file extension
     */
    public function testAssertReturnFormatInvalid()
    {
        Assert::assertReturnFormat('xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("XXX")
     */
    public function testAssertReturnFormatInvalidWithCustomMessage()
    {
        Assert::assertReturnFormat('XXX', 'Custom error message (%s)');
    }
}
