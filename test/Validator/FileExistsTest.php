<?php

namespace TxTextControlTest\ReportingCloud\Validator;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Validator\FileExists as Validator;

class FileExistsTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    protected $filename;

    public function setUp()
    {
        $this->filename = tempnam(sys_get_temp_dir(), md5(__CLASS__));

        touch($this->filename);

        $this->validator = new Validator();
    }

    public function tearDown()
    {
        unlink($this->filename);
    }

    public function testValid()
    {
        $this->assertTrue($this->validator->isValid($this->filename));
    }

    public function testInvalidFilename()
    {
        $this->assertFalse($this->validator->isValid('/tmp/aaaaaaa.txt'));
        $this->assertArrayHasKey('invalidFilename', $this->validator->getMessages());
    }

}
