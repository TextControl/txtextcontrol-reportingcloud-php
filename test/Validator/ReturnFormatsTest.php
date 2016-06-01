<?php

namespace TXTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TXTextControl\ReportingCloud\Validator\ReturnFormats as Validator;

class ReturnFormatsTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testDefault()
    {
        $this->assertTrue($this->validator->isValid('pdf'));
        $this->assertTrue($this->validator->isValid('PDF'));
    }

    public function testInvalid()
    {
        $this->assertFalse($this->validator->isValid('tif'));
        $this->assertFalse($this->validator->isValid('TIF'));
    }

}
