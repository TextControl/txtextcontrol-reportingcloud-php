<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\ReturnFormat as Validator;

class ReturnFormatTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('DOC'));
        $this->assertTrue($this->validator->isValid('doc'));
        $this->assertTrue($this->validator->isValid('DOCX'));
        $this->assertTrue($this->validator->isValid('docx'));
        $this->assertTrue($this->validator->isValid('HTML'));
        $this->assertTrue($this->validator->isValid('html'));
        $this->assertTrue($this->validator->isValid('PDF'));
        $this->assertTrue($this->validator->isValid('pdf'));
        $this->assertTrue($this->validator->isValid('PDFA'));
        $this->assertTrue($this->validator->isValid('pdfa'));
        $this->assertTrue($this->validator->isValid('RTF'));
        $this->assertTrue($this->validator->isValid('rtf'));
        $this->assertTrue($this->validator->isValid('TX'));
        $this->assertTrue($this->validator->isValid('tx'));
    }

    public function testUnsupportedExtension()
    {
        $this->assertFalse($this->validator->isValid('tif'));
        $this->assertArrayHasKey(Validator::UNSUPPORTED_EXTENSION, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('TIF'));
        $this->assertArrayHasKey(Validator::UNSUPPORTED_EXTENSION, $this->validator->getMessages());
    }
}
