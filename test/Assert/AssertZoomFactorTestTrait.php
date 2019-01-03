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
 * Trait AssertZoomFactorTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertZoomFactorTestTrait
{
    public function testAssertZoomFactor()
    {
        $this->assertNull(Assert::assertZoomFactor(250));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Zoom factor (-1) must be in the range [1..400]
     */
    public function testAssertZoomFactorInvalidTooSmall()
    {
        Assert::assertZoomFactor(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (600) - range: [1..400]
     */
    public function testAssertZoomFactorInvalidWithCustomMessage()
    {
        Assert::assertZoomFactor(600, 'Custom error message (%s) - range: [%2$s..%3$s]');
    }
}
