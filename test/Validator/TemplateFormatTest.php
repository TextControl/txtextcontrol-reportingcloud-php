<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\TemplateFormat as Validator;

class TemplateFormatTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('doc'));
        $this->assertTrue($this->validator->isValid('DOC'));
    }

    public function testUnsupportedExtension()
    {
        $this->assertFalse($this->validator->isValid('tif'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('TIF'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('fish.doc'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());
    }
}
