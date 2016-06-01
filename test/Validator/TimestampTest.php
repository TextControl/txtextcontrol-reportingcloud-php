<?php

namespace TXTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TXTextControl\ReportingCloud\Validator\Timestamp as Validator;

class TimestampTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testDefault()
    {
        $this->assertTrue($this->validator->isValid(1000));
        $this->assertTrue($this->validator->isValid(10000000));

        $this->assertFalse($this->validator->isValid(-1));
        $this->assertFalse($this->validator->isValid('invalid'));
    }
}
