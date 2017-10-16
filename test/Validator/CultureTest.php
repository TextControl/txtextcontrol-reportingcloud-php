<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\Culture as Validator;

class CultureTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('de-DE'));
        $this->assertTrue($this->validator->isValid('fr-FR'));
        $this->assertTrue($this->validator->isValid('en-US'));
    }

    public function testInvalid()
    {
        $this->assertFalse($this->validator->isValid('de-XX'));
        $this->assertArrayHasKey(Validator::INVALID_VALUE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('de'));
        $this->assertArrayHasKey(Validator::INVALID_VALUE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey(Validator::INVALID_VALUE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(1));
        $this->assertArrayHasKey(Validator::INVALID_VALUE, $this->validator->getMessages());
    }

    public function testConstructor()
    {
        $validator = new Validator(null);

        $this->assertTrue($validator->isValid('de-DE'));
    }
}
