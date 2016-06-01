<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\ImageFormats as Validator;

class ImageFormatsTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('png'));
        $this->assertTrue($this->validator->isValid('PNG'));
    }

    public function testInvalid()
    {
        $this->assertFalse($this->validator->isValid('doc'));
        $this->assertFalse($this->validator->isValid('DOC'));
    }

}
