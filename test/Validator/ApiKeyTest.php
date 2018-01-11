<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\ApiKey as Validator;

class ApiKeyTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $minimumLengthApiKey = 'aaaaaaaaaaaaaaaaaaaa';
        $this->assertTrue($this->validator->isValid($minimumLengthApiKey));

        $tooShortApiKey = 'aaaaaaaaaaaaaaaaaaa';
        $this->assertFalse($this->validator->isValid($tooShortApiKey));
        $this->assertArrayHasKey(Validator::INVALID_STRING, $this->validator->getMessages());

        $maximumLengthApiKey = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $this->assertTrue($this->validator->isValid($maximumLengthApiKey));

        $tooLongApiKey = "{$maximumLengthApiKey}a";
        $this->assertFalse($this->validator->isValid($tooLongApiKey));
        $this->assertArrayHasKey(Validator::INVALID_STRING, $this->validator->getMessages());
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->validator->isValid(8));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(null));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(true));
        $this->assertArrayHasKey(Validator::INVALID_TYPE, $this->validator->getMessages());
    }

    public function testConstructor()
    {
        $validator = new Validator(null);

        $this->assertTrue($validator->isValid('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'));
    }
}
