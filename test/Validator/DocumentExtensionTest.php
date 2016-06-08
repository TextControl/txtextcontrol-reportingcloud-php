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

    public function testValid()
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

    public function testInvalidExtension()
    {
        $this->assertFalse($this->validator->isValid('/path/to/document.xxx'));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('/path/to/document.'));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('/path/to/document'));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('/path/to/document/'));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(1));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(null));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(false));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());
    }

}
