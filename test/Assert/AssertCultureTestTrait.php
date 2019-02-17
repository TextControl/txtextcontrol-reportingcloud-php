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
 * Trait AssertCultureTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertCultureTestTrait
{
    public function testAssertCulture(): void
    {
        $this->assertNull(Assert::assertCulture('de-DE'));
        $this->assertNull(Assert::assertCulture('fr-FR'));
        $this->assertNull(Assert::assertCulture('en-US'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "de-XX" contains an unsupported culture
     */
    public function testAssertCultureInvalid(): void
    {
        Assert::assertCulture('de-XX');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("xx-XX")
     */
    public function testAssertCultureInvalidWithCustomMessage(): void
    {
        Assert::assertCulture('xx-XX', 'Custom error message ("%s")');
    }
}
