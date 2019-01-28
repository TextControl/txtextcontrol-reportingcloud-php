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

        $response       = $this->reportingCloud->appendDocument($documents, 'PDF', $documentSettings);
        $responseLength = mb_strlen($response);

        $this->assertNotNull($response);
        $this->assertNotFalse($response);
        $this->assertGreaterThanOrEqual(1024, $responseLength);
    }

    // </editor-fold>

    // <editor-fold desc="convertDocument">

    public function testConvertDocument(): void
    {
        $documentFilename = $this->getTestDocumentFilename();

        $this->assertFileExists($documentFilename);

        $response       = $this->reportingCloud->convertDocument($documentFilename, 'PDF');
        $responseLength = mb_strlen($response);

        $this->assertNotNull($response);
        $this->assertNotFalse($response);
        $this->assertGreaterThanOrEqual(1024, $responseLength);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidDocumentFilenameUnsupportedExtension(): void
    {
        $this->reportingCloud->convertDocument('/invalid/path/document.xxx', 'PDF');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidDocumentFilenameNoExtension(): void
    {
        $this->reportingCloud->convertDocument('/invalid/path/document', 'PDF');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidDocumentFilenameNoFile(): void
    {
        $this->reportingCloud->convertDocument('/invalid/path/document/', 'PDF');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidDocumentFilename(): void
    {
        $this->reportingCloud->convertDocument('/invalid/path/document.doc', 'PDF');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidReturnFormat(): void
    {
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

            $this->assertNotNull($response);
            $this->assertNotFalse($response);
            $this->assertGreaterThanOrEqual(1024, mb_strlen($response));
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

            $this->assertNotNull($response);
            $this->assertNotFalse($response);
            $this->assertGreaterThanOrEqual(1024, mb_strlen($response));
        }

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidReturnFormat(): void
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'X');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateName(): void
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', '../invalid_template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateFilenameUnsupportedExtension(): void
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, '/invalid/path/template.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateFilenameNoExtension(): void
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, '/invalid/path/template');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateFilenameNoFile(): void
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, '/invalid/path/template/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateFilename(): void
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, '/invalid/path/template.doc');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidMergeSettingsStringInsteadOfBoolean(): void
    {
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
            'PDF',
            null,
            $templateFilename,
            $mergeSettings
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidMergeSettingsTimestampValues(): void
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();
        $mergeSettings      = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFindAndReplaceFilename();

        $this->assertFileExists($templateFilename);

        // value must be timestamp
        $mergeSettings['creation_date']          = -1;
        $mergeSettings['last_modification_date'] = 'invalid';

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            'PDF',
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

            $this->assertNotNull($response);
            $this->assertNotFalse($response);
            $this->assertArrayHasKey(0, $response);

            foreach ($response as $key => $page) {
                $this->assertTrue(is_int($key));
                $this->assertGreaterThanOrEqual(1024, mb_strlen($page));
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

            $this->assertNotNull($response);
            $this->assertNotFalse($response);
            $this->assertArrayHasKey(0, $response);

            foreach ($response as $key => $page) {
                $this->assertTrue(is_int($key));
                $this->assertGreaterThanOrEqual(1024, mb_strlen($page));
            }
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidReturnFormat(): void
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'X');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateName(): void
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', '../invalid_template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateFilenameUnsupportedExtension(): void
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, '/invalid/path/template.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateFilenameNoExtension(): void
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, '/invalid/path/template');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateFilenameNoFile(): void
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, '/invalid/path/template/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateFilename(): void
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, '/invalid/path/template.doc');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidMergeSettingsStringInsteadOfBoolean(): void
    {
        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($templateFilename);

        // value must be boolean
        $mergeSettings['remove_empty_blocks'] = 'invalid';
        $mergeSettings['remove_empty_fields'] = 'invalid';
        $mergeSettings['remove_empty_images'] = 'invalid';

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, $templateFilename, false, $mergeSettings);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidCultureValue(): void
    {
        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($templateFilename);

        $mergeSettings['culture'] = 'invalid';

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, $templateFilename, false, $mergeSettings);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidMergeSettingsTimestampValues(): void
    {
        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($templateFilename);

        // value must be timestamp
        $mergeSettings['creation_date']          = -1;
        $mergeSettings['last_modification_date'] = 'invalid';

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, $templateFilename, false, $mergeSettings);
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

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadTemplateInvalidTemplateFilenameUnsupportedExtension(): void
    {
        $this->reportingCloud->uploadTemplate('/invalid/path/document.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadTemplateInvalidTemplateFilenameNoExtension(): void
    {
        $this->reportingCloud->uploadTemplate('/invalid/path/document');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadTemplateInvalidTemplateFilenameNoFile(): void
    {
        $this->reportingCloud->uploadTemplate('/invalid/path/document/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadTemplateInvalidTemplateFilename(): void
    {
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

        $tempTemplateBinary = file_get_contents($tempTemplateFilename);
        $tempTemplateBase64 = base64_encode($tempTemplateBinary);

        $response = $this->reportingCloud->uploadTemplateFromBase64($tempTemplateBase64, $tempTemplateName);
        $this->assertTrue($response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>
}
