<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertBase64DataTestTrait
{
    public function testAssertBase64Data()
    {
        $value = base64_encode('ReportingCloud rocks!');
        $this->assertNull(Assert::assertBase64Data($value));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "#*abc" must be base64 encoded
     */
    public function testAssertBase64DataInvalidCharacters()
    {
        Assert::assertBase64Data('#*abc');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "-1" must be base64 encoded
     */
    public function testAssertBase64DataInvalidDigits()
    {
        Assert::assertBase64Data('-1');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "[]" must be base64 encoded
     */
    public function testAssertBase64DataInvalidBrackets()
    {
        Assert::assertBase64Data('[]');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("**********")
     */
    public function testAssertBase64DataWithCustomMessage()
    {
        Assert::assertBase64Data('**********', 'Custom error message (%s)');
    }
}
