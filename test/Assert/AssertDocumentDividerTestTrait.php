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
 * Trait AssertDocumentDividerTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertDocumentDividerTestTrait
{
    public function testAssertDocumentDivider(): void
    {
        $this->assertNull(Assert::assertDocumentDivider(1));
        $this->assertNull(Assert::assertDocumentDivider(2));
        $this->assertNull(Assert::assertDocumentDivider(3));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage 10 contains an unsupported document divider
     */
    public function testAssertDocumentDividerInvalid(): void
    {
        Assert::assertDocumentDivider(10);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message (-10)
     */
    public function testAssertDocumentDividerInvalidWithCustomMessage(): void
    {
        Assert::assertDocumentDivider(-10, 'Custom error message (%s)');
    }
}
