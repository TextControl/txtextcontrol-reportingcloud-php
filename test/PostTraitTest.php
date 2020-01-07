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

namespace TxTextControlTest\ReportingCloud;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait PostTraitTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait PostTraitTest
{
    /**
     * @var ReportingCloud
     */
    protected $reportingCloud;

    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $actual
     * @param string $message
     */
    abstract public static function assertNotEmpty($actual, string $message = ''): void;

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertFalse($condition, string $message = ''): void;

    /**
     * @param string $filename
     * @param string $message
     */
    abstract public static function assertFileExists(string $filename, string $message = ''): void;

    /**
     * @param mixed  $needle
     * @param mixed  $haystack
     * @param string $message
     * @param bool   $ignoreCase
     * @param bool   $checkForObjectIdentity
     * @param bool   $checkForNonObjectIdentity
     */
    abstract public static function assertContains(
        $needle,
        $haystack,
        string $message = '',
        bool $ignoreCase = false,
        bool $checkForObjectIdentity = true,
        bool $checkForNonObjectIdentity = false
    ): void;

    /**
     * @param mixed  $expected
     * @param mixed  $actual
     * @param string $message
     * @param float  $delta
     * @param int    $maxDepth
     * @param bool   $canonicalize
     * @param bool   $ignoreCase
     */
    abstract public static function assertEquals(
        $expected,
        $actual,
        string $message = '',
        float $delta = 0.0,
        int $maxDepth = 10,
        bool $canonicalize = false,
        bool $ignoreCase = false
    ): void;

    /**
     * @param mixed  $expected
     * @param mixed  $actual
     * @param string $message
     */
    abstract public static function assertSame($expected, $actual, string $message = ''): void;

    /**
     * @param mixed  $actual
     * @param string $message
     */
    abstract public static function assertNotNull($actual, string $message = ''): void;

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertNotFalse($condition, string $message = ''): void;

    /**
     * @param mixed  $expected
     * @param mixed  $actual
     * @param string $message
     */
    abstract public static function assertGreaterThan($expected, $actual, string $message = ''): void;

    /**
     * @param mixed  $expected
     * @param mixed  $actual
     * @param string $message
     */
    abstract public static function assertGreaterThanOrEqual($expected, $actual, string $message = ''): void;

    /**
     * @param mixed  $key
     * @param mixed  $array
     * @param string $message
     */
    abstract public static function assertArrayHasKey($key, $array, string $message = ''): void;

    /**
     * @param string $exception
     */
    abstract public function expectException(string $exception): void;

    /**
     * @return string
     */
    abstract protected function getTestTemplateFilename(): string;

    /**
     * @return string
     */
    abstract protected function getTempTemplateFilename(): string;

    /**
     * @return string
     */
    abstract protected function getTestDocumentFilename(): string;

    /**
     * @return string
     */
    abstract protected function getTestDocumentTrackedChangesFilename(): string;

    /**
     * @return array
     */
    abstract protected function getTestDocumentSettings(): array;

    /**
     * @return array
     */
    abstract protected function getTestMergeSettings(): array;

    /**
     * @return array
     */
    abstract protected function getTestTemplateFindAndReplaceData(): array;

    /**
     * @return string
     */
    abstract protected function getTestTemplateFindAndReplaceFilename(): string;

    /**
     * @return array
     */
    abstract protected function getTestTemplateMergeData(): array;

    /**
     *
     */
    abstract protected function deleteAllApiKeys(): void;

    // </editor-fold>

    // <editor-fold desc="appendDocument">

    public function testAppendDocument(): void
    {
        $documents = [
            [
                'filename' => $this->getTestDocumentFilename(),
                'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NONE,
            ],
            [
                'filename' => $this->getTestDocumentFilename(),
                'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_PARAGRAPH,
            ],
            [
                'filename' => $this->getTestDocumentFilename(),
                'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
            ],
        ];

        $documentSettings = $this->getTestDocumentSettings();

        $response = $this->reportingCloud->appendDocument(
            $documents,
            ReportingCloud::FILE_FORMAT_PDF,
            $documentSettings
        );
    }

    // </editor-fold>

    // <editor-fold desc="convertDocument">

    public function testConvertDocumentToPdf(): void
    {
        $documentFilename = $this->getTestDocumentFilename();

        $this->assertFileExists($documentFilename);

        $response = $this->reportingCloud->convertDocument(
            $documentFilename,
            ReportingCloud::FILE_FORMAT_PDF
        );

        $this->assertGreaterThanOrEqual(1024, mb_strlen($response));
    }

    public function testConvertDocumentToTxt(): void
    {
        $documentFilename = $this->getTestDocumentFilename();

        $this->assertFileExists($documentFilename);

        $response = $this->reportingCloud->convertDocument(
            $documentFilename,
            ReportingCloud::FILE_FORMAT_TXT
        );

        $this->assertNotFalse($response);
        $this->assertEquals("A Test File\r\n", $response);
    }

    public function testConvertDocumentInvalidDocumentFilenameUnsupportedExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->convertDocument(
            '/invalid/path/document.xxx',
            ReportingCloud::FILE_FORMAT_PDF
        );
    }

    public function testConvertDocumentInvalidDocumentFilenameNoExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->convertDocument(
            '/invalid/path/document',
            ReportingCloud::FILE_FORMAT_PDF
        );
    }

    public function testConvertDocumentInvalidDocumentFilenameNoFile(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->convertDocument(
            '/invalid/path/document/',
            ReportingCloud::FILE_FORMAT_PDF
        );
    }

    public function testConvertDocumentInvalidDocumentFilename(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->convertDocument(
            '/invalid/path/document.doc',
            ReportingCloud::FILE_FORMAT_PDF
        );
    }

    public function testConvertDocumentInvalidReturnFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $documentFilename = $this->getTestTemplateFilename();

        $this->reportingCloud->convertDocument($documentFilename, 'XXX');
    }

    // </editor-fold>

    // <editor-fold desc="findAndReplaceDocument">

    public function testFindAndReplaceDocumentWithTemplateFilename(): void
    {
        $returnFormats = ReportingCloud::FILE_FORMATS_RETURN;

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();
        $mergeSettings      = $this->getTestMergeSettings();

        $testTemplateFilename = $this->getTestTemplateFindAndReplaceFilename();

        $this->assertFileExists($testTemplateFilename);

        foreach ($returnFormats as $returnFormat) {

            $response = $this->reportingCloud->findAndReplaceDocument(
                $findAndReplaceData,
                $returnFormat,
                null,
                $testTemplateFilename,
                $mergeSettings
            );

            $this->assertGreaterThanOrEqual(64, mb_strlen($response));
        }
    }

    public function testFindAndReplaceDocumentWithTemplateName(): void
    {
        $returnFormats = ReportingCloud::FILE_FORMATS_RETURN;

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();
        $mergeSettings      = $this->getTestMergeSettings();

        $testTemplateFilename = $this->getTestTemplateFindAndReplaceFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);

        foreach ($returnFormats as $returnFormat) {

            $response = $this->reportingCloud->findAndReplaceDocument(
                $findAndReplaceData,
                $returnFormat,
                $tempTemplateName,
                null,
                $mergeSettings
            );

            $this->assertGreaterThanOrEqual(64, mb_strlen($response));
        }

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);
    }

    public function testFindAndReplaceDocumentInvalidReturnFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'X');
    }

    public function testFindAndReplaceDocumentInvalidTemplateName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            '../invalid_template.tx'
        );
    }

    public function testFindAndReplaceDocumentInvalidTemplateFilenameUnsupportedExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            '/invalid/path/template.xxx'
        );
    }

    public function testFindAndReplaceDocumentInvalidTemplateFilenameNoExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            '/invalid/path/template'
        );
    }

    public function testFindAndReplaceDocumentInvalidTemplateFilenameNoFile(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            '/invalid/path/template/'
        );
    }

    public function testFindAndReplaceDocumentInvalidTemplateFilename(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            '/invalid/path/template.doc'
        );
    }

    public function testFindAndReplaceDocumentInvalidMergeSettingsStringInsteadOfBoolean(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();
        $mergeSettings      = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFindAndReplaceFilename();

        $this->assertFileExists($templateFilename);

        // value must be boolean
        $mergeSettings['remove_empty_blocks'] = 'invalid';
        $mergeSettings['remove_empty_fields'] = 'invalid';
        $mergeSettings['remove_empty_images'] = 'invalid';

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            $templateFilename,
            $mergeSettings
        );
    }

    public function testFindAndReplaceDocumentInvalidMergeSettingsTimestampValues(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();
        $mergeSettings      = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFindAndReplaceFilename();

        $this->assertFileExists($templateFilename);

        // value must be timestamp
        $mergeSettings['creation_date']          = -1;
        $mergeSettings['last_modification_date'] = 'invalid';

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            $templateFilename,
            $mergeSettings
        );
    }

    // </editor-fold>

    // <editor-fold desc="mergeDocument">

    public function testMergeDocumentWithTemplateName(): void
    {
        $returnFormats = ReportingCloud::FILE_FORMATS_RETURN;

        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);

        foreach ($returnFormats as $returnFormat) {

            $response = $this->reportingCloud->mergeDocument(
                $mergeData,
                $returnFormat,
                $tempTemplateName,
                null,
                false,
                $mergeSettings
            );

            $this->assertArrayHasKey(0, $response);

            foreach ($response as $key => $page) {
                $this->assertTrue(is_int($key));
                $this->assertNotNull($page);
                $this->assertNotFalse($page);
            }
        }

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);
    }

    public function testMergeDocumentWithTemplateFilename(): void
    {
        $returnFormats = ReportingCloud::FILE_FORMATS_RETURN;

        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $testTemplateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($testTemplateFilename);

        foreach ($returnFormats as $returnFormat) {

            $response = $this->reportingCloud->mergeDocument(
                $mergeData,
                $returnFormat,
                null,
                $testTemplateFilename,
                false,
                $mergeSettings
            );

            $this->assertArrayHasKey(0, $response);

            foreach ($response as $key => $page) {
                $page = (string) $page;
                $this->assertTrue(is_int($key));
                $this->assertGreaterThanOrEqual(128, mb_strlen($page));
            }
        }
    }

    public function testMergeDocumentInvalidReturnFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'X');
    }

    public function testMergeDocumentInvalidTemplateName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            '../invalid_template.tx'
        );
    }

    public function testMergeDocumentInvalidTemplateFilenameUnsupportedExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            '/invalid/path/template.xxx'
        );
    }

    public function testMergeDocumentInvalidTemplateFilenameNoExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            '/invalid/path/template'
        );
    }

    public function testMergeDocumentInvalidTemplateFilenameNoFile(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            '/invalid/path/template/'
        );
    }

    public function testMergeDocumentInvalidTemplateFilename(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            '/invalid/path/template.doc'
        );
    }

    public function testMergeDocumentInvalidMergeSettingsStringInsteadOfBoolean(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($templateFilename);

        // value must be boolean
        $mergeSettings['remove_empty_blocks'] = 'invalid';
        $mergeSettings['remove_empty_fields'] = 'invalid';
        $mergeSettings['remove_empty_images'] = 'invalid';

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            $templateFilename,
            false,
            $mergeSettings
        );
    }

    public function testMergeDocumentInvalidCultureValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($templateFilename);

        $mergeSettings['culture'] = 'invalid';

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            $templateFilename,
            false,
            $mergeSettings
        );
    }

    public function testMergeDocumentInvalidMergeSettingsTimestampValues(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($templateFilename);

        // value must be timestamp
        $mergeSettings['creation_date']          = -1;
        $mergeSettings['last_modification_date'] = 'invalid';

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            null,
            $templateFilename,
            false,
            $mergeSettings
        );
    }

    // </editor-fold>

    // <editor-fold desc="uploadTemplate">

    public function testUploadTemplate(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);
        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);
        $this->assertTrue($response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    public function testUploadTemplateInvalidTemplateFilenameUnsupportedExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->uploadTemplate('/invalid/path/document.xxx');
    }

    public function testUploadTemplateInvalidTemplateFilenameNoExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->uploadTemplate('/invalid/path/document');
    }

    public function testUploadTemplateInvalidTemplateFilenameNoFile(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->uploadTemplate('/invalid/path/document/');
    }

    public function testUploadTemplateInvalidTemplateFilename(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->uploadTemplate('/invalid/path/template.doc');
    }

    // </editor-fold>

    // <editor-fold desc="uploadTemplateFromBase64">

    public function testUploadTemplateFromBase64(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);
        $this->assertFileExists($tempTemplateFilename);

        $tempTemplateBinary = (string) file_get_contents($tempTemplateFilename);
        $tempTemplateBase64 = base64_encode($tempTemplateBinary);

        $response = $this->reportingCloud->uploadTemplateFromBase64($tempTemplateBase64, $tempTemplateName);
        $this->assertTrue($response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getDocumentThumbnails">

    public function testGetDocumentThumbnails(): void
    {
        $testDocumentFilename = $this->getTestDocumentFilename();

        $this->assertFileExists($testDocumentFilename);

        $response = $this->reportingCloud->getDocumentThumbnails(
            $testDocumentFilename,
            100,
            1,
            1,
            ReportingCloud::FILE_FORMAT_PNG
        );

        $this->assertArrayHasKey(0, $response);

        $this->assertTrue(mb_strlen($response[0]) > 2048);
    }

    // </editor-fold>


    // <editor-fold desc="getTrackedChanges">

    public function testGetTrackedChanges(): void
    {
        $testDocumentFilename = $this->getTestDocumentTrackedChangesFilename();

        $this->assertFileExists($testDocumentFilename);

        $response = $this->reportingCloud->getTrackedChanges(
            $testDocumentFilename
        );

        $this->assertArrayHasKey(0, $response);

        $this->assertArrayHasKey('change_kind', $response[0]);
        $this->assertArrayHasKey('change_time', $response[0]);
        $this->assertArrayHasKey('default_highlight_color', $response[0]);
        $this->assertArrayHasKey('highlight_color', $response[0]);
        $this->assertArrayHasKey('highlight_mode', $response[0]);
        $this->assertArrayHasKey('length', $response[0]);
        $this->assertArrayHasKey('start', $response[0]);
        $this->assertArrayHasKey('id', $response[0]);
        $this->assertArrayHasKey('text', $response[0]);
        $this->assertArrayHasKey('username', $response[0]);
    }

    // </editor-fold>

    // <editor-fold desc="removeTrackedChange">

    public function testRemoveTrackedChange(): void
    {
        $testDocumentFilename = $this->getTestDocumentTrackedChangesFilename();

        $this->assertFileExists($testDocumentFilename);

        $response = $this->reportingCloud->removeTrackedChange(
            $testDocumentFilename,
            1,
            true
        );

        $this->assertArrayHasKey('document', $response);
        $this->assertArrayHasKey('removed', $response);
    }

    // </editor-fold>
}
