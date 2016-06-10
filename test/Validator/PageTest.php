<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\Page as Validator;

class PageTest extends PHPUnit_Framework_TestCase
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
        $this->assertTrue($this->validator->isValid(PHP_INT_MAX));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->validator->isValid('invalid'));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('1'));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(true));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());
    }

    public function testInvalidInteger()
    {
        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey('invalidInteger', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(-1));
        $this->assertArrayHasKey('invalidInteger', $this->validator->getMessages());
    }

    public function testConstructor()
    {
        $validator = new Validator(null);

        $this->assertTrue($validator->isValid(1));
    }
}
