<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\Base64Data as Validator;

class Base64DataTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $value = base64_encode('ReportingCloud rocks!');
        $this->assertTrue($this->validator->isValid($value));
    }

    public function testInvalid()
    {
        $value = '#*abc';
        $this->assertFalse($this->validator->isValid($value));
        $this->assertArrayHasKey(Validator::INVALID_ENCODING, $this->validator->getMessages());

        $value = '-1';
        $this->assertFalse($this->validator->isValid($value));
        $this->assertArrayHasKey(Validator::INVALID_ENCODING, $this->validator->getMessages());

        $value = '[]';
        $this->assertFalse($this->validator->isValid($value));
        $this->assertArrayHasKey(Validator::INVALID_ENCODING, $this->validator->getMessages());
    }

    public function testConstructorWithDefaultOptions()
    {
        $validator = new Validator();
        $value     = base64_encode('ReportingCloud rocks!');
        $this->assertTrue($validator->isValid($value));
        unset($validator);
    }

    public function testConstructorWithEmptyArray()
    {
        $validator = new Validator([]);
        $value     = base64_encode('ReportingCloud rocks!');
        $this->assertTrue($validator->isValid($value));
        unset($validator);
    }
}
