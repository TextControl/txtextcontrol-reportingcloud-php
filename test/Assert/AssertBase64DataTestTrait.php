<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

/**
 * Trait AssertBase64DataTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertBase64DataTestTrait
{
    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    // </editor-fold>

    public function testAssertBase64Data(): void
    {
        $value = base64_encode('ReportingCloud rocks!');
        Assert::assertBase64Data($value);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "#*abc" must be base64 encoded
     */
    public function testAssertBase64DataInvalidCharacters(): void
    {
        Assert::assertBase64Data('#*abc');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "-1" must be base64 encoded
     */
    public function testAssertBase64DataInvalidDigits(): void
    {
        Assert::assertBase64Data('-1');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "[]" must be base64 encoded
     */
    public function testAssertBase64DataInvalidBrackets(): void
    {
        Assert::assertBase64Data('[]');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("**********")
     */
    public function testAssertBase64DataWithCustomMessage(): void
    {
        Assert::assertBase64Data('**********', 'Custom error message (%1$s)');
    }
}
