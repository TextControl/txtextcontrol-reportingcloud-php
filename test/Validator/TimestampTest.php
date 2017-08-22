<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\Timestamp as Validator;

class TimestampTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid(0));
        $this->assertTrue($this->validator->isValid(1));
        $this->assertTrue($this->validator->isValid(1000));
        $this->assertTrue($this->validator->isValid(10000000));
        $this->assertTrue($this->validator->isValid(PHP_INT_MAX));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->validator->isValid('2016-06-02T15:49:57+00:00'));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(1.1));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(null));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(true));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(false));
        $this->assertArrayHasKey('invalidType', $this->validator->getMessages());
    }

    public function testInvalidRange()
    {
        $this->assertFalse($this->validator->isValid(-1));
        $this->assertArrayHasKey('invalidRange', $this->validator->getMessages());
    }
}
