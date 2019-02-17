<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
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
 * Trait AssertApiKeyTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertApiKeyTestTrait
{
    public function testAssertApiKey(): void
    {
        $this->assertNull(Assert::assertApiKey('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'));
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
