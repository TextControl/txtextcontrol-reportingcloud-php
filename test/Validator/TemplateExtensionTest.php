<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\TemplateExtension as Validator;

class TemplateExtensionTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('./template.tx'));
        $this->assertTrue($this->validator->isValid('./TEMPLATE.TX'));

        $this->assertTrue($this->validator->isValid('../template.tx'));
        $this->assertTrue($this->validator->isValid('../TEMPLATE.TX'));

        $this->assertTrue($this->validator->isValid('/../template.tx'));
        $this->assertTrue($this->validator->isValid('/../TEMPLATE.TX'));

        $this->assertTrue($this->validator->isValid('/path/to/template.tx'));
        $this->assertTrue($this->validator->isValid('/PATH/TO/TEMPLATE.TX'));

        $this->assertTrue($this->validator->isValid('c:\path\to\template.tx'));
        $this->assertTrue($this->validator->isValid('c:\PATH\TO\TEMPLATE.TX'));
    }

    public function testUnsupportedExtension()
    {
        $this->assertFalse($this->validator->isValid('/path/to/template.xxx'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('/path/to/template.'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('/path/to/template'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('/path/to/template/'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(1));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(null));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(false));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());
    }

}
