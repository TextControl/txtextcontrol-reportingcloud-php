<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\TemplateName as Validator;

class TemplateNameTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('template.tx'));
        $this->assertTrue($this->validator->isValid('template.TX'));
        $this->assertTrue($this->validator->isValid('TEMPLATE.TX'));

        $this->assertTrue($this->validator->isValid('template.doc'));
        $this->assertTrue($this->validator->isValid('template.DOC'));
        $this->assertTrue($this->validator->isValid('TEMPLATE.DOC'));
    }

    public function testInvalidPath()
    {
        $this->assertFalse($this->validator->isValid('/path/to/template.tx'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('/../template.tx'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('../template.tx'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('./template.tx'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('./'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('../'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('../'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('./a'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('../a'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('../a'));
        $this->assertArrayHasKey('invalidPath', $this->validator->getMessages());
    }

    public function testInvalidExtension()
    {
        $this->assertFalse($this->validator->isValid('..'));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('0'));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(0));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(true));
        $this->assertArrayHasKey('invalidExtension', $this->validator->getMessages());
    }

    public function testInvalidBasename()
    {
        $this->assertFalse($this->validator->isValid('.tx'));
        $this->assertArrayHasKey('invalidBasename', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('.'));
        $this->assertArrayHasKey('invalidBasename', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('.a'));
        $this->assertArrayHasKey('invalidBasename', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(''));
        $this->assertArrayHasKey('invalidBasename', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid(false));
        $this->assertArrayHasKey('invalidBasename', $this->validator->getMessages());
    }

    public function testUnsupportedExtension()
    {
        $this->assertFalse($this->validator->isValid('..a'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('template.pdf'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());
    }

}
