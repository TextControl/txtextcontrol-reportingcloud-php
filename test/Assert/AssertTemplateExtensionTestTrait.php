<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2021 Text Control GmbH
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
    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    /**
     * @param string $exception
     */
    abstract public function expectException(string $exception): void;

    /**
     * @param string $message
     */
    abstract public function expectExceptionMessage(string $message): void;

    // </editor-fold>

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

    public function testAssertTemplateExtensionInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"template.xxx" contains an unsupported template format file extension');

        Assert::assertTemplateExtension('template.xxx');
    }

    public function testAssertTemplateExtensionInvalidWithCustomMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Custom error message ("template.xxx")');

        Assert::assertTemplateExtension('template.xxx', 'Custom error message (%1$s)');
    }
}
