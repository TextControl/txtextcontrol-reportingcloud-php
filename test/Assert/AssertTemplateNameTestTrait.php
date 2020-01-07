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
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Assert\Assert;

/**
 * Trait AssertTemplateNameTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTemplateNameTestTrait
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

    public function testAssertTemplateName(): void
    {
        Assert::assertTemplateName('template.tx');
        Assert::assertTemplateName('template.TX');
        Assert::assertTemplateName('TEMPLATE.TX');

        Assert::assertTemplateName('template.doc');
        Assert::assertTemplateName('template.DOC');
        Assert::assertTemplateName('TEMPLATE.DOC');

        $this->assertTrue(true);
    }

    public function testAssertTemplateNameInvalidUnsupportedFileExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"template.xxx" contains an unsupported file extension');

        Assert::assertTemplateName('template.xxx');
    }

    public function testAssertTemplateNameInvalidAbsolutePath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"/path/to/template.tx" contains path information (\'/\', \'.\', or \'..\')');

        Assert::assertTemplateName('/path/to/template.tx');
    }

    public function testAssertTemplateNameInvalidDirectoryTraversal1(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"/../template.tx" contains path information (\'/\', \'.\', or \'..\')');

        Assert::assertTemplateName('/../template.tx');
    }

    public function testAssertTemplateNameInvalidDirectoryTraversal2(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"../template.tx" contains path information (\'/\', \'.\', or \'..\')');

        Assert::assertTemplateName('../template.tx');
    }

    public function testAssertTemplateNameInvalidPath4(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"./template.tx" contains path information (\'/\', \'.\', or \'..\')');

        Assert::assertTemplateName('./template.tx');
    }

    public function testAssertTemplateNameInvalidWithCustomMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Custom error message ("invalid.xxx")');

        Assert::assertTemplateName('invalid.xxx', 'Custom error message (%1$s)');
    }
}
