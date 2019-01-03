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
 * Trait AssertDateTimeTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertDateTimeTestTrait
{
    public function testAssertDateTime()
    {
        $this->assertNull(Assert::assertDateTime('2016-06-02T15:49:57+00:00'));
        $this->assertNull(Assert::assertDateTime('1980-06-02T15:49:57+00:00'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "2016-06-02T15:49:57+00:00:00" has an invalid number of characters in it
     */
    public function testAssertDateTimeInvalidLength()
    {
        Assert::assertDateTime('2016-06-02T15:49:57+00:00:00');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "xxxx-06-02T15:49:57+00:00" is syntactically invalid
     */
    public function testAssertDateTimeInvalidSyntax()
    {
        Assert::assertDateTime('xxxx-06-02T15:49:57+00:00');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "2016-06-02T15:49:57+02:00" has an invalid offset
     */
    public function testAssertDateTimeInvalidOffset()
    {
        Assert::assertDateTime('2016-06-02T15:49:57+02:00');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("0000-00-00T00:00:00+xx:xx")
     */
    public function testAssertDateTimeInvalidWithCustomMessage()
    {
        Assert::assertDateTime('0000-00-00T00:00:00+xx:xx', 'Custom error message (%s)');
    }
}
