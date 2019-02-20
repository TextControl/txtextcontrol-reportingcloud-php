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

use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait AssertApiKeyTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertApiKeyTestTrait
{
    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    // </editor-fold>

    public function testAssertApiKey(): void
    {
        Assert::assertApiKey('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Length of API key ("xxxxxxxxxx") must be in the range [20..45]
     */
    public function testAssertApiKeyInvalidTooShort(): void
    {
        Assert::assertApiKey('xxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Length of API key ("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx") must be in
     * the range [20..45]
     */
    public function testAssertApiKeyInvalidTooLong(): void
    {
        Assert::assertApiKey('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid length: ("xxxxxxxxxx") must be in the range [20..45]
     */
    public function testAssertApiKeyInvalidWithCustomMessage(): void
    {
        Assert::assertApiKey('xxxxxxxxxx', 'Invalid length: ("%s") must be in the range [%2$s..%3$s]');
    }
}
