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
        $this->assertTrue($this->validator->isValid('en_US.dic'));
        $this->assertTrue($this->validator->isValid('en.dic'));
        $this->assertTrue($this->validator->isValid('en_US_OpenMedSpel.dic'));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->validator->isValid('EN_US.dic'));
        $this->assertArrayHasKey('invalidSyntax', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('DE_de.DIC'));
        $this->assertArrayHasKey('invalidSyntax', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('deDE.dic'));
        $this->assertArrayHasKey('invalidSyntax', $this->validator->getMessages());
    }

    public function testConstructor()
    {
        $validator = new Validator(null);

        $this->assertTrue($validator->isValid('en_US.dic'));
    }
}
