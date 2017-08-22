<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\TypeInteger as Validator;

class TypeIntegerTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid(1));
        $this->assertTrue($this->validator->isValid(0));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->validator->isValid([
            1,
            2,
            3,
            4,
        ]));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('1'));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(true));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(false));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(null));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());
    }
}
