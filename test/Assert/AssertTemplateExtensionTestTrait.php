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
        Assert::assertTemplateExtension('./template.tx');
        Assert::assertTemplateExtension('./TEMPLATE.TX');

        Assert::assertTemplateExtension('../template.tx');
        Assert::assertTemplateExtension('../TEMPLATE.TX');

        Assert::assertTemplateExtension('/../template.tx');
        Assert::assertTemplateExtension('/../TEMPLATE.TX');

        Assert::assertTemplateExtension('/path/to/template.tx');
        Assert::assertTemplateExtension('/PATH/TO/TEMPLATE.TX');

        Assert::assertTemplateExtension('c:\path\to\template.tx');
        Assert::assertTemplateExtension('c:\PATH\TO\TEMPLATE.TX');

        Assert::assertTemplateExtension('.tx');
        Assert::assertTemplateExtension('.TX');

        Assert::assertTemplateExtension('1.tx');
        Assert::assertTemplateExtension('1.TX');

        Assert::assertTemplateExtension('a.tx');
        Assert::assertTemplateExtension('A.TX');

        $this->assertTrue(true);
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
