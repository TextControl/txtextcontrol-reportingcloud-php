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
 * Trait AssertTemplateExtensionTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTemplateExtensionTestTrait
{
    public function testAssertTemplateExtension(): void
    {
        $this->assertNull(Assert::assertTemplateExtension('./template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('./TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('../template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('../TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('/../template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('/../TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('/path/to/template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('/PATH/TO/TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('c:\path\to\template.tx'));
        $this->assertNull(Assert::assertTemplateExtension('c:\PATH\TO\TEMPLATE.TX'));

        $this->assertNull(Assert::assertTemplateExtension('.tx'));
        $this->assertNull(Assert::assertTemplateExtension('.TX'));

        $this->assertNull(Assert::assertTemplateExtension('1.tx'));
        $this->assertNull(Assert::assertTemplateExtension('1.TX'));

        $this->assertNull(Assert::assertTemplateExtension('a.tx'));
        $this->assertNull(Assert::assertTemplateExtension('A.TX'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "template.xxx" contains an unsupported template format file extension
     */
    public function testAssertTemplateExtensionInvalid(): void
    {
        Assert::assertTemplateExtension('template.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("template.xxx")
     */
    public function testAssertTemplateExtensionInvalidWithCustomMessage(): void
    {
        Assert::assertTemplateExtension('template.xxx', 'Custom error message ("%s")');
    }
}
