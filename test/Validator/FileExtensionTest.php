<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\FileExtension as Validator;

class FileExtensionTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();

        $this->validator->setHaystack([
            'DOC',
            'DOCX',
            'RTF',
            'TX',
        ]);
    }

    public function testConstructorOptions()
    {
        $haystack = [
            'DOC',
            'DOCX',
            'RTF',
            'TX',
        ];

        $validator = new Validator([
            'haystack' => $haystack,
        ]);

        $this->assertSame($haystack, $validator->getHaystack());
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid('doc'));
        $this->assertTrue($this->validator->isValid('DOC'));
    }

    public function testUnsupportedExtension()
    {
        $this->assertFalse($this->validator->isValid('tif'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());

        $this->assertFalse($this->validator->isValid('TIF'));
        $this->assertArrayHasKey('unsupportedExtension', $this->validator->getMessages());
    }
}
