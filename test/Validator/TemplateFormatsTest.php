<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\TemplateFormats as Validator;

class TemplateFormatsTest extends PHPUnit_Framework_TestCase
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

    public function testNotInArray()
    {
        $this->assertFalse($this->validator->isValid('tif'));
        $this->assertArrayHasKey('notInArray', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('TIF'));
        $this->assertArrayHasKey('notInArray', $this->validator->getMessages());
    }

}
