<?php

namespace TXTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TXTextControl\ReportingCloud\Validator\TemplateName as Validator;

class TemplateNameTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testPath()
    {
        $this->assertTrue($this->validator->isValid('template.tx'));
        $this->assertTrue($this->validator->isValid('template.TX'));
        $this->assertTrue($this->validator->isValid('TEMPLATE.TX'));

        $this->assertFalse($this->validator->isValid('/path/to/template.tx'));
        $this->assertFalse($this->validator->isValid('/../template.tx'));
        $this->assertFalse($this->validator->isValid('../template.tx'));
        $this->assertFalse($this->validator->isValid('./template.tx'));
        $this->assertFalse($this->validator->isValid('.tx'));
        $this->assertFalse($this->validator->isValid('..'));
        $this->assertFalse($this->validator->isValid('.'));
        $this->assertFalse($this->validator->isValid('./'));
        $this->assertFalse($this->validator->isValid('../'));
        $this->assertFalse($this->validator->isValid('../'));
        $this->assertFalse($this->validator->isValid('..a'));
        $this->assertFalse($this->validator->isValid('.a'));
        $this->assertFalse($this->validator->isValid('./a'));
        $this->assertFalse($this->validator->isValid('../a'));
        $this->assertFalse($this->validator->isValid('../a'));
    }

    public function testExtension()
    {
        $this->assertTrue($this->validator->isValid('template.doc'));
        $this->assertTrue($this->validator->isValid('template.DOC'));
        $this->assertTrue($this->validator->isValid('TEMPLATE.DOC'));

        $this->assertFalse($this->validator->isValid('template.pdf'));
    }
}
