<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\ZoomFactor as Validator;

class ZoomFactorTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid(1));
        $this->assertTrue($this->validator->isValid(2));
        $this->assertTrue($this->validator->isValid(Validator::MAX));
        $this->assertTrue($this->validator->isValid(Validator::MIN));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->validator->isValid('invalid'));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('1'));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(true));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());
    }

    public function testInvalidInteger()
    {
        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey(Validator::INVALID_INTEGER, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(Validator::MAX + 1));
        $this->assertArrayHasKey(Validator::INVALID_INTEGER, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(Validator::MIN - 1));
        $this->assertArrayHasKey(Validator::INVALID_INTEGER, $this->validator->getMessages());
    }

    public function testConstructor()
    {
        $validator = new Validator(null);

        $this->assertTrue($validator->isValid(1));
    }
}
