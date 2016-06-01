<?php

namespace TXTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TXTextControl\ReportingCloud\Validator\TemplateFormats as Validator;

class TemplateFormatsTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testDefault()
    {
        $this->assertTrue($this->validator->isValid('doc'));
        $this->assertTrue($this->validator->isValid('DOC'));
    }

    public function testInvalid()
    {
        $this->assertFalse($this->validator->isValid('tif'));
        $this->assertFalse($this->validator->isValid('TIF'));
    }

}
