<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\DocumentExtension as Validator;

class DocumentExtensionTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testDefault()
    {
        $this->assertTrue($this->validator->isValid('./document.doc'));
        $this->assertTrue($this->validator->isValid('./DOCUMENT.DOC'));

        $this->assertTrue($this->validator->isValid('../document.doc'));
        $this->assertTrue($this->validator->isValid('../DOCUMENT.DOC'));

        $this->assertTrue($this->validator->isValid('/../document.doc'));
        $this->assertTrue($this->validator->isValid('/../DOCUMENT.DOC'));

        $this->assertTrue($this->validator->isValid('/path/to/document.doc'));
        $this->assertTrue($this->validator->isValid('/PATH/TO/DOCUMENT.DOC'));

        $this->assertTrue($this->validator->isValid('c:\path\to\document.doc'));
        $this->assertTrue($this->validator->isValid('c:\PATH\TO\DOCUMENT.DOC'));
    }

    public function testInvalid()
    {
        $this->assertFalse($this->validator->isValid('/path/to/document.xxx'));
        $this->assertFalse($this->validator->isValid('/path/to/document.'));
        $this->assertFalse($this->validator->isValid('/path/to/document'));
        $this->assertFalse($this->validator->isValid('/path/to/document/'));

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertFalse($this->validator->isValid(0));
        $this->assertFalse($this->validator->isValid(1));
        $this->assertFalse($this->validator->isValid(null));
        $this->assertFalse($this->validator->isValid(false));
    }

}
