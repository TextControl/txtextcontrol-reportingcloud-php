<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\TypeBoolean as Validator;

class TypeBooleanTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid(true));
        $this->assertTrue($this->validator->isValid(false));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(1));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(null));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());
    }
}
