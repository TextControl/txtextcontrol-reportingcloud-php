<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\TypeArray as Validator;

class TypeArrayTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid([
                                                        'a' => 1,
                                                        'b' => 1,
                                                        'c' => 1,
                                                        'd' => 1,
                                                    ]));
        $this->assertTrue($this->validator->isValid([
                                                        1,
                                                        2,
                                                        3,
                                                        4,
                                                    ]));
        $this->assertTrue($this->validator->isValid([]));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(1));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(false));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(null));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());
    }
}
