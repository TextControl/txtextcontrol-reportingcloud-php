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
 * Trait AssertStringTraitTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertStringTraitTest
{
    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    // </editor-fold>

    public function testAssertString(): void
    {
        Assert::assertString('a');

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a string. Got: array
     */
    public function testAssertStringWithArray(): void
    {
        Assert::assertString([1]);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a string. Got: false
     */
    public function testAssertStringWithBoolean(): void
    {
        Assert::assertString(false);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a string. Got: 1
     */
    public function testAssertStringWithInteger(): void
    {
        Assert::assertString(1);

        $this->assertTrue(true);
    }
}
