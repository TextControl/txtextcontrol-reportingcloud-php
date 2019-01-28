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
 * Trait AssertPageTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertPageTestTrait
{
    public function testAssertPage(): void
    {
        $this->assertNull(Assert::assertPage(1));
        $this->assertNull(Assert::assertPage(2));
        $this->assertNull(Assert::assertPage(PHP_INT_MAX));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Page number (-1) must be in the range [1..9223372036854775807]
     */
    public function testAssertPageInvalidTooSmall(): void
    {
        Assert::assertPage(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (-50) - range: [1..9223372036854775807]
     */
    public function testAssertPageInvalidWithCustomMessage(): void
    {
        Assert::assertPage(-50, 'Custom error message (%s) - range: [%2$s..%3$s]');
    }
}
