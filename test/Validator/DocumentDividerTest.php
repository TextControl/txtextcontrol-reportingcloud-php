<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\DocumentDivider as Validator;

class DocumentDivider extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('1'));
        $this->assertTrue($this->validator->isValid('2'));
        $this->assertTrue($this->validator->isValid('3'));

        $this->assertTrue($this->validator->isValid(1));
        $this->assertTrue($this->validator->isValid(2));
        $this->assertTrue($this->validator->isValid(3));
    }

    public function testInvalid()
    {
        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey(Validator::UNSUPPORTED_DIVIDER, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey(Validator::UNSUPPORTED_DIVIDER, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('4'));
        $this->assertArrayHasKey(Validator::UNSUPPORTED_DIVIDER, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(4));
        $this->assertArrayHasKey(Validator::UNSUPPORTED_DIVIDER, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('a'));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('b'));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(true));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(false));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());
    }
}
