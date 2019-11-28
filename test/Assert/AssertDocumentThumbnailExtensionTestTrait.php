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
 * @copyright © 2020 Text Control GmbH
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

        $this->assertTrue(true);
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
