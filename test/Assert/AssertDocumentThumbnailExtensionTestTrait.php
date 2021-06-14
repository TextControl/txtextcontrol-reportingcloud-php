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

use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait AssertDocumentExtensionTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertDocumentThumbnailExtensionTestTrait
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

    public function testAssertDocumentThumbnailExtension(): void
    {
        Assert::assertDocumentThumbnailExtension('./document.xlsx');
        Assert::assertDocumentThumbnailExtension('./DOCUMENT.XLSX');

        Assert::assertDocumentThumbnailExtension('./document.doc');
        Assert::assertDocumentThumbnailExtension('./DOCUMENT.DOC');

        Assert::assertDocumentThumbnailExtension('../document.doc');
        Assert::assertDocumentThumbnailExtension('../DOCUMENT.DOC');

        Assert::assertDocumentThumbnailExtension('/../document.doc');
        Assert::assertDocumentThumbnailExtension('/../DOCUMENT.DOC');

        Assert::assertDocumentThumbnailExtension('/path/to/document.doc');
        Assert::assertDocumentThumbnailExtension('/PATH/TO/DOCUMENT.DOC');

        Assert::assertDocumentThumbnailExtension('c:\path\to\document.doc');
        Assert::assertDocumentThumbnailExtension('c:\PATH\TO\DOCUMENT.DOC');

        self::assertTrue(true);
    }

    public function testAssertDocumentThumbnailExtensionInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"document.xxx" contains an unsupported document '
                                      . 'thumbnail format file extension');

        Assert::assertDocumentThumbnailExtension('document.xxx');
    }

    public function testAssertDocumentThumbnailExtensionInvalidWithCustomMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Custom error message ("document.xxx")');

        Assert::assertDocumentThumbnailExtension('document.xxx', 'Custom error message (%1$s)');
    }
}
