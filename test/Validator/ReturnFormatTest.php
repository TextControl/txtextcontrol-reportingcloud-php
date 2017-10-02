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
        $this->assertTrue($this->validator->isValid('pdf'));
        $this->assertTrue($this->validator->isValid('PDF'));
    }

    public function testUnsupportedExtension()
    {
        $this->assertFalse($this->validator->isValid('tif'));
        $this->assertArrayHasKey(Validator::UNSUPPORTED_EXTENSION, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('TIF'));
        $this->assertArrayHasKey(Validator::UNSUPPORTED_EXTENSION, $this->validator->getMessages());
    }
}
