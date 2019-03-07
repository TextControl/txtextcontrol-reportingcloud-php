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
 * Trait AssertBooleanTraitTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertBooleanTraitTest
{
    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    // </editor-fold>

    public function testAssertBoolean(): void
    {
        Assert::assertBoolean(true);
        Assert::assertBoolean(false);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a boolean. Got: 1
     */
    public function testAssertBooleanWithInteger(): void
    {
        Assert::assertBoolean(1);

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a boolean. Got: "a"
     */
    public function testAssertBooleanWithString(): void
    {
        Assert::assertBoolean('a');

        $this->assertTrue(true);
    }
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a boolean. Got: array
     */
    public function testAssertBooleanWithArray(): void
    {
        Assert::assertBoolean([1]);

        $this->assertTrue(true);
    }
}
