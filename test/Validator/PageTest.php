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

    public function testNotGreaterThanInclusive()
    {
        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey('notGreaterThanInclusive', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(-1));
        $this->assertArrayHasKey('notGreaterThanInclusive', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('invalid'));
        $this->assertArrayHasKey('notGreaterThanInclusive', $this->validator->getMessages());
    }

    public function testConstructor()
    {
        $validator = new Validator(null);

        $this->assertTrue($validator->isValid(1));
    }
}
