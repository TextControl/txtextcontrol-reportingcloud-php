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

    public function testDefault()
    {
        $this->assertTrue($this->validator->isValid(1));
        $this->assertTrue($this->validator->isValid(2));
        $this->assertTrue($this->validator->isValid(PHP_INT_MAX));

        $this->assertFalse($this->validator->isValid(0));
        $this->assertFalse($this->validator->isValid(-1));
        $this->assertFalse($this->validator->isValid('invalid'));
    }

    public function testConstructor()
    {
        $validator = new Validator(null);

        $this->assertTrue($validator->isValid(1));
    }
}
