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
 * Trait AssertDocumentExtensionTestTrait
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertDocumentExtensionTestTrait
{
    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    // </editor-fold>

    public function testAssertDocumentExtension(): void
    {
        Assert::assertDocumentExtension('./document.doc');
        Assert::assertDocumentExtension('./DOCUMENT.DOC');

        Assert::assertDocumentExtension('../document.doc');
        Assert::assertDocumentExtension('../DOCUMENT.DOC');

        Assert::assertDocumentExtension('/../document.doc');
        Assert::assertDocumentExtension('/../DOCUMENT.DOC');

        Assert::assertDocumentExtension('/path/to/document.doc');
        Assert::assertDocumentExtension('/PATH/TO/DOCUMENT.DOC');

        Assert::assertDocumentExtension('c:\path\to\document.doc');
        Assert::assertDocumentExtension('c:\PATH\TO\DOCUMENT.DOC');

        $this->assertTrue(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "document.xxx" contains an unsupported document format file extension
     */
    public function testAssertDocumentExtensionInvalid(): void
    {
        Assert::assertDocumentExtension('document.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Custom error message ("document.xxx")
     */
    public function testAssertDocumentExtensionInvalidWithCustomMessage(): void
    {
        Assert::assertDocumentExtension('document.xxx', 'Custom error message ("%s")');
    }
}
