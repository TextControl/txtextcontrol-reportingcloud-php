<?php

namespace TxTextControlTest\ReportingCloud\Assert;

use InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

trait AssertLanguageTestTrait
{
    public function testAssertLanguage()
    {
        $this->assertNull(Assert::assertLanguage('de_CH_frami.dic'));
        $this->assertNull(Assert::assertLanguage('pt_BR.dic'));
        $this->assertNull(Assert::assertLanguage('nb_NO.dic'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "pt_BR" contains an unsupported language
     */
    public function testAssertLanguageInvalid()
    {
        Assert::assertLanguage('pt_BR');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("xx_XX")
     */
    public function testAssertLanguageInvalidWithCustomMessage()
    {
        Assert::assertLanguage('xx_XX', 'Custom error message (%s)');
    }
}
