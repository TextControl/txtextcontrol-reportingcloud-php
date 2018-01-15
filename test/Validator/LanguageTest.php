<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\Language as Validator;

class LanguageTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('de_CH_frami.dic'));
        $this->assertTrue($this->validator->isValid('pt_BR.dic'));
        $this->assertTrue($this->validator->isValid('nb_NO.dic'));
    }

    public function testInvalid()
    {
        $this->assertFalse($this->validator->isValid('pt_BR'));
        $this->assertArrayHasKey(Validator::INVALID_VALUE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('pt'));
        $this->assertArrayHasKey(Validator::INVALID_VALUE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey(Validator::INVALID_VALUE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(1));
        $this->assertArrayHasKey(Validator::INVALID_VALUE, $this->validator->getMessages());
    }

    public function testConstructorWithDefaultOptions()
    {
        $validator = new Validator();
        $this->assertTrue($validator->isValid('en_US.dic'));
        unset($validator);
    }

    public function testConstructorWithEmptyArray()
    {
        $validator = new Validator([]);
        $this->assertTrue($validator->isValid('en_US.dic'));
        unset($validator);
    }
}
