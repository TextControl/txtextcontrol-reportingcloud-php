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

namespace TxTextControlTest\ReportingCloud;

use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use GuzzleHttp\Client;

/**
 * Class ReportingCloudTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloudTest extends AbstractReportingCloudTest
{
    // <editor-fold desc="Helpers tests">

    public function testAuthenticationWithEmptyCredentials(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $reportingCloud = new ReportingCloud();

        $reportingCloud->setUsername('');
        $reportingCloud->setPassword('');
        $reportingCloud->setApiKey('');

        $reportingCloud->getFontList();
    }

    public function testAuthenticationWithApiKey(): void
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        self::assertNotEmpty($apiKey);

        $reportingCloud2 = new ReportingCloud();

        $reportingCloud2->setTest(true);
        $reportingCloud2->setApiKey($apiKey);

        self::assertEquals($apiKey, $reportingCloud2->getApiKey());
        self::assertContains('Times New Roman', $reportingCloud2->getFontList());

        $this->deleteAllApiKeys();

        unset($reportingCloud2);
    }

    public function testConstructorOptions(): void
    {
        $options = [
            'username' => 'phpunit-username',
            'password' => 'phpunit-password',
            'base_uri' => 'https://api.example.com',
            'timeout'  => 100,
            'version'  => 'v1',
            'debug'    => true,
            'test'     => true,
        ];

        $reportingCloud = new ReportingCloud($options);

        self::assertSame('phpunit-username', $reportingCloud->getUsername());
        self::assertSame('phpunit-password', $reportingCloud->getPassword());
        self::assertSame('https://api.example.com', $reportingCloud->getBaseUri());
        self::assertSame(100, $reportingCloud->getTimeout());
        self::assertSame('v1', $reportingCloud->getVersion());

        self::assertTrue($reportingCloud->getDebug());
        self::assertTrue($reportingCloud->getTest());

        unset($reportingCloud);
    }

    public function testSetGetProperties(): void
    {
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');
        $this->reportingCloud->setBaseUri('https://api.example.com');
        $this->reportingCloud->setTimeout(100);
        $this->reportingCloud->setVersion('v1');
        $this->reportingCloud->setDebug(true);
        $this->reportingCloud->setTest(true);

        self::assertSame('phpunit-username', $this->reportingCloud->getUsername());
        self::assertSame('phpunit-password', $this->reportingCloud->getPassword());
        self::assertSame('https://api.example.com', $this->reportingCloud->getBaseUri());
        self::assertSame(100, $this->reportingCloud->getTimeout());
        self::assertSame('v1', $this->reportingCloud->getVersion());

        self::assertTrue($this->reportingCloud->getDebug());
        self::assertTrue($this->reportingCloud->getTest());
    }

    public function testGetClientInstanceOf(): void
    {
        self::assertInstanceOf(Client::class, $this->reportingCloud->getClient());
    }

    public function testGetClientWithUsernameAndPassword(): void
    {
        $this->reportingCloud->setApiKey('');
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');

        self::assertInstanceOf(Client::class, $this->reportingCloud->getClient());
    }

    public function testDefaultProperties(): void
    {
        $reportingCloud = new ReportingCloud();

        self::assertEmpty($reportingCloud->getUsername());
        self::assertEmpty($reportingCloud->getPassword());

        $envVarName = ConsoleUtils::BASE_URI;
        $baseUri    = getenv($envVarName);
        if (is_string($baseUri) && strlen($baseUri) > 0) {
            $expected = $baseUri;
        } else {
            $expected = 'https://api.reporting.cloud';
        }
        self::assertSame($expected, $reportingCloud->getBaseUri());
        self::assertSame(120, $reportingCloud->getTimeout());
        self::assertSame('v1', $reportingCloud->getVersion());

        self::assertFalse($reportingCloud->getDebug());

        unset($reportingCloud);
    }

    public function testGetBaseUriFromEnvVar(): void
    {
        $baseUri = ConsoleUtils::baseUri();

        if (strlen($baseUri) > 0) {
            $reportingCloud = new ReportingCloud();
            self::assertSame($baseUri, $reportingCloud->getBaseUri());
            unset($reportingCloud);
        }
    }

    public function testGetBaseUriFromEnvVarWithNull(): void
    {
        $envVarName = ConsoleUtils::BASE_URI;
        $baseUri    = getenv($envVarName);

        putenv("{$envVarName}");

        $reportingCloud = new ReportingCloud();
        self::assertSame('https://api.reporting.cloud', $reportingCloud->getBaseUri());
        unset($reportingCloud);

        putenv("{$envVarName}={$baseUri}");
    }

    public function testGetBaseUriFromEnvVarWithEmptyValue(): void
    {
        $envVarName = ConsoleUtils::BASE_URI;
        $baseUri    = getenv($envVarName);

        putenv("{$envVarName}=");

        $reportingCloud = new ReportingCloud();
        self::assertSame('https://api.reporting.cloud', $reportingCloud->getBaseUri());
        unset($reportingCloud);

        putenv("{$envVarName}={$baseUri}");
    }

    public function testGetBaseUriFromEnvVarWithInvalidValue(): void
    {
        $envVarName = ConsoleUtils::BASE_URI;
        $baseUri    = getenv($envVarName);
        if (is_string($baseUri) && strlen($baseUri) > 0) {
            putenv("{$envVarName}=https://www.example.com");
            try {
                $reportingCloud = new ReportingCloud();
            } catch (InvalidArgumentException $e) {
                putenv("{$envVarName}={$baseUri}");
                $expected = 'Expected base URI to end in "api.reporting.cloud". Got "https://www.example.com"';
                self::assertSame($expected, $e->getMessage());
            }
            if (isset($reportingCloud)) {
                unset($reportingCloud);
            }
        }
    }

    // </editor-fold>

    // <editor-fold desc="HTTP DELETE tests">

    // <editor-fold desc="deleteApiKey">

    public function testDeleteApiKey(): void
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        self::assertNotEmpty($apiKey);

        $response = $this->reportingCloud->deleteApiKey($apiKey);
        self::assertTrue($response);
    }

    // </editor-fold>

    // <editor-fold desc="deleteTemplate">

    public function testDeleteTemplate(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);
        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);
        self::assertTrue($response);

        $templateNames = [];
        $templateList  = $this->reportingCloud->getTemplateList();
        foreach ($templateList as $record) {
            $templateNames[] = $record['template_name'];
        }
        self::assertContains($tempTemplateName, $templateNames);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        self::assertTrue($response);

        unlink($tempTemplateFilename);
    }

    public function testDeleteTemplateInvalidTemplateName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $templateName = $this->getTestTemplateFilename();
        $this->reportingCloud->deleteTemplate($templateName);
    }

    public function testDeleteTemplateRuntimeException(): void
    {
        $this->expectException(RuntimeException::class);

        $this->reportingCloud->deleteTemplate('invalid-template.tx');
    }

    // </editor-fold>

    // </editor-fold>

    // <editor-fold desc="HTTP GET tests">

    // <editor-fold desc="downloadTemplate">

    public function testDownloadTemplate(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);
        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);
        self::assertTrue($response);

        $response       = $this->reportingCloud->downloadTemplate($tempTemplateName);
        $responseLength = mb_strlen($response);
        self::assertGreaterThanOrEqual(1024, $responseLength);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        self::assertTrue($response);

        unlink($tempTemplateFilename);
    }

    public function testDownloadTemplateInvalidTemplateName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        // should be templateName and not templateFilename
        $templateFilename = $this->getTestTemplateFilename();

        $this->reportingCloud->downloadTemplate($templateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getAccountSettings">

    public function testGetAccountSettings(): void
    {
        $response = $this->reportingCloud->getAccountSettings();

        self::assertArrayHasKey('serial_number', $response);
        self::assertArrayHasKey('created_documents', $response);
        self::assertArrayHasKey('uploaded_templates', $response);
        self::assertArrayHasKey('max_documents', $response);
        self::assertArrayHasKey('max_templates', $response);
        self::assertArrayHasKey('valid_until', $response);

        self::assertTrue(is_string($response['serial_number']));
        self::assertTrue(is_int($response['created_documents']));
        self::assertTrue(is_int($response['uploaded_templates']));
        self::assertTrue(is_int($response['max_documents']));
        self::assertTrue(is_int($response['max_templates']));
        self::assertTrue(is_int($response['valid_until']));
    }

    // </editor-fold>

    // <editor-fold desc="getApiKeys">

    public function testGetApiKeys(): void
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        self::assertNotEmpty($apiKey);

        $apiKeys = $this->reportingCloud->getApiKeys();
        self::assertArrayHasKey(0, $apiKeys);
        self::assertArrayHasKey('key', $apiKeys[0]);
        self::assertArrayHasKey('active', $apiKeys[0]);
        self::assertTrue(is_string($apiKeys[0]['key']));
        self::assertTrue(is_bool($apiKeys[0]['active']));
    }

    // </editor-fold>

    // <editor-fold desc="getAvailableDictionaries">

    public function testGetAvailableDictionaries(): void
    {
        $filename = Assert::getDictionariesFilename();

        $actual   = $this->reportingCloud->getAvailableDictionaries();
        $expected = include $filename;

        sort($actual);
        sort($expected);

        self::assertEquals($expected, $actual);
    }

    // </editor-fold>

    // <editor-fold desc="getFontList">

    public function testGetFontList(): void
    {
        $fonts = $this->reportingCloud->getFontList();

        self::assertContains('Times New Roman', $fonts);
        self::assertContains('Arial', $fonts);
        self::assertContains('Courier New', $fonts);

        self::assertArrayHasKey(0, $fonts);
        self::assertArrayHasKey(1, $fonts);
        self::assertArrayHasKey(2, $fonts);
    }

    // </editor-fold>

    // <editor-fold desc="getProofingSuggestions">

    public function testGetProofingSuggestions(): void
    {
        $response = $this->reportingCloud->getProofingSuggestions('Thiss', 'en_US.dic', 5);

        self::assertTrue(5 === count($response));

        self::assertContains('This', $response);
    }

    // </editor-fold>

    // <editor-fold desc="getTemplateCount">

    public function testGetTemplateCount(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        self::assertTrue($response);

        $response = $this->reportingCloud->getTemplateCount();

        self::assertGreaterThan(0, $response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        self::assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getTemplateInfo">

    public function testGetTemplateInfo(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        self::assertTrue($response);

        $response = $this->reportingCloud->getTemplateInfo($tempTemplateName);

        self::assertArrayHasKey('template_name', $response);

        self::assertArrayHasKey('merge_blocks', $response);

        self::assertArrayHasKey(0, $response['merge_blocks']);

        self::assertArrayHasKey('name', $response['merge_blocks'][0]);
        self::assertArrayHasKey('merge_fields', $response['merge_blocks'][0]);

        self::assertArrayHasKey(0, $response['merge_blocks'][0]['merge_fields']);

        self::assertArrayHasKey('date_time_format', $response['merge_blocks'][0]['merge_fields'][0]);
        self::assertArrayHasKey('numeric_format', $response['merge_blocks'][0]['merge_fields'][0]);
        self::assertArrayHasKey('preserve_formatting', $response['merge_blocks'][0]['merge_fields'][0]);
        self::assertArrayHasKey('text', $response['merge_blocks'][0]['merge_fields'][0]);
        self::assertArrayHasKey('text_after', $response['merge_blocks'][0]['merge_fields'][0]);
        self::assertArrayHasKey('text_before', $response['merge_blocks'][0]['merge_fields'][0]);

        self::assertArrayHasKey('merge_fields', $response);

        self::assertArrayHasKey(0, $response['merge_fields']);

        self::assertArrayHasKey('date_time_format', $response['merge_fields'][0]);
        self::assertArrayHasKey('numeric_format', $response['merge_fields'][0]);
        self::assertArrayHasKey('preserve_formatting', $response['merge_fields'][0]);
        self::assertArrayHasKey('text', $response['merge_fields'][0]);
        self::assertArrayHasKey('text_after', $response['merge_fields'][0]);
        self::assertArrayHasKey('text_before', $response['merge_fields'][0]);

        self::assertArrayHasKey('user_document_properties', $response);

        self::assertEquals(true, is_array($response['user_document_properties']));

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        self::assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getTemplateList">

    public function testGetTemplateList(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        self::assertTrue($response);

        $response = $this->reportingCloud->getTemplateList();

        self::assertArrayHasKey(0, $response);

        self::assertArrayHasKey('template_name', $response[0]);
        self::assertArrayHasKey('modified', $response[0]);
        self::assertArrayHasKey('size', $response[0]);

        self::assertTrue(is_string($response[0]['template_name']));
        self::assertTrue(is_int($response[0]['modified']));
        self::assertTrue(is_int($response[0]['size']));

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        self::assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getTemplatePageCount">

    public function testGetTemplatePageCount(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        self::assertTrue($response);

        $response = $this->reportingCloud->getTemplatePageCount($tempTemplateName);

        self::assertSame(1, $response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        self::assertTrue($response);

        unlink($tempTemplateFilename);
    }

    public function testGetTemplatePageCountInvalidTemplateName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->getTemplatePageCount('sample_invoice.xx');
    }


    // </editor-fold>

    // <editor-fold desc="getTemplateThumbnails">

    public function testGetTemplateThumbnails(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        self::assertTrue($response);

        $response = $this->reportingCloud->getTemplateThumbnails(
            $tempTemplateName,
            100,
            1,
            1,
            ReportingCloud::FILE_FORMAT_PNG
        );

        self::assertArrayHasKey(0, $response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        self::assertTrue($response);

        unlink($tempTemplateFilename);
    }

    public function testGetTemplateThumbnailsInvalidTemplateName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->getTemplateThumbnails(
            'sample_invoice.xx',
            100,
            1,
            1,
            ReportingCloud::FILE_FORMAT_PNG
        );
    }

    public function testGetTemplateThumbnailsInvalidZoomFactor(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->getTemplateThumbnails(
            'sample_invoice.tx',
            -1,
            1,
            1,
            ReportingCloud::FILE_FORMAT_PNG
        );
    }

    public function testGetTemplateThumbnailsInvalidFromPage(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->getTemplateThumbnails(
            'sample_invoice.tx',
            100,
            -1,
            1,
            ReportingCloud::FILE_FORMAT_PNG
        );
    }

    public function testGetTemplateThumbnailsInvalidToPage(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->getTemplateThumbnails(
            'sample_invoice.tx',
            100,
            1,
            -1,
            ReportingCloud::FILE_FORMAT_PNG
        );
    }

    public function testGetTemplateThumbnailsInvalidImageFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->getTemplateThumbnails(
            'sample_invoice.tx',
            100,
            1,
            1,
            'XXX'
        );
    }

    // </editor-fold>

    // <editor-fold desc="proofingCheck">

    public function testProofingCheck(): void
    {
        $response = $this->reportingCloud->proofingCheck('Thiss is a dog', 'en_US.dic');

        self::assertArrayHasKey(0, $response);

        $response = $response[0];
        assert(is_array($response));

        self::assertArrayHasKey('length', $response);
        self::assertArrayHasKey('start', $response);
        self::assertArrayHasKey('text', $response);
        self::assertArrayHasKey('is_duplicate', $response);
        self::assertArrayHasKey('language', $response);

        self::assertEquals(5, $response['length']);
        self::assertEquals(0, $response['start']);
        self::assertEquals('Thiss', $response['text']);
        self::assertEquals(false, $response['is_duplicate']);
        self::assertEquals('en_US.dic', $response['language']);
    }

    // </editor-fold>

    // <editor-fold desc="templateExists">

    public function testTemplateExists(): void
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        self::assertTrue($response);

        $response = $this->reportingCloud->templateExists($tempTemplateName);

        self::assertTrue($response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        self::assertTrue($response);

        $response = $this->reportingCloud->templateExists($tempTemplateName);

        self::assertFalse($response);

        unlink($tempTemplateFilename);
    }

    public function testTemplateExistsInvalidTemplateName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->reportingCloud->templateExists('sample_invoice.xx');
    }

    // </editor-fold>

    // </editor-fold>

    // <editor-fold desc="HTTP POST tests">

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

        self::assertNotFalse($response);
        self::assertGreaterThanOrEqual(1024, mb_strlen($response));
    }

    // </editor-fold>

    // <editor-fold desc="convertDocument">

    public function testConvertDocumentToPdf(): void
    {
        $documentFilename = $this->getTestDocumentFilename();

        self::assertFileExists($documentFilename);

        $response = $this->reportingCloud->convertDocument(
            $documentFilename,
            ReportingCloud::FILE_FORMAT_PDF
        );

        self::assertGreaterThanOrEqual(1024, mb_strlen($response));
    }

    public function testConvertDocumentToTxt(): void
    {
        $documentFilename = $this->getTestDocumentFilename();

        self::assertFileExists($documentFilename);

        $response = $this->reportingCloud->convertDocument(
            $documentFilename,
            ReportingCloud::FILE_FORMAT_TXT
        );

        self::assertNotFalse($response);
        self::assertEquals("A Test File\r\n", $response);
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

        self::assertFileExists($testTemplateFilename);

        foreach ($returnFormats as $returnFormat) {

            $response = $this->reportingCloud->findAndReplaceDocument(
                $findAndReplaceData,
                $returnFormat,
                '',
                $testTemplateFilename,
                $mergeSettings
            );

            self::assertGreaterThanOrEqual(64, mb_strlen($response));
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

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        self::assertTrue($response);

        unlink($tempTemplateFilename);

        foreach ($returnFormats as $returnFormat) {

            $response = $this->reportingCloud->findAndReplaceDocument(
                $findAndReplaceData,
                $returnFormat,
                $tempTemplateName,
                '',
                $mergeSettings
            );

            self::assertGreaterThanOrEqual(64, mb_strlen($response));
        }

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        self::assertTrue($response);
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
            '',
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
            '',
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
            '',
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
            '',
            '/invalid/path/template.doc'
        );
    }

    public function testFindAndReplaceDocumentInvalidMergeSettingsStringInsteadOfBoolean(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();
        $mergeSettings      = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFindAndReplaceFilename();

        self::assertFileExists($templateFilename);

        // value must be boolean
        $mergeSettings['remove_empty_blocks'] = 'invalid';
        $mergeSettings['remove_empty_fields'] = 'invalid';
        $mergeSettings['remove_empty_images'] = 'invalid';

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            '',
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

        self::assertFileExists($templateFilename);

        // value must be timestamp
        $mergeSettings['creation_date']          = -1;
        $mergeSettings['last_modification_date'] = 'invalid';

        $this->reportingCloud->findAndReplaceDocument(
            $findAndReplaceData,
            ReportingCloud::FILE_FORMAT_PDF,
            '',
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

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        self::assertTrue($response);

        unlink($tempTemplateFilename);

        foreach ($returnFormats as $returnFormat) {

            $response = $this->reportingCloud->mergeDocument(
                $mergeData,
                $returnFormat,
                $tempTemplateName,
                '',
                false,
                $mergeSettings
            );

            self::assertArrayHasKey(0, $response);

            foreach ($response as $key => $page) {
                self::assertTrue(is_int($key));
                self::assertNotNull($page);
                self::assertNotFalse($page);
            }
        }

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        self::assertTrue($response);
    }

    public function testMergeDocumentWithTemplateFilename(): void
    {
        $returnFormats = ReportingCloud::FILE_FORMATS_RETURN;

        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $testTemplateFilename = $this->getTestTemplateFilename();

        self::assertFileExists($testTemplateFilename);

        foreach ($returnFormats as $returnFormat) {

            $response = $this->reportingCloud->mergeDocument(
                $mergeData,
                $returnFormat,
                '',
                $testTemplateFilename,
                false,
                $mergeSettings
            );

            self::assertArrayHasKey(0, $response);

            foreach ($response as $key => $page) {
                $page = (string) $page;
                self::assertTrue(is_int($key));
                self::assertGreaterThanOrEqual(128, mb_strlen($page));
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
            '',
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
            '',
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
            '',
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
            '',
            '/invalid/path/template.doc'
        );
    }

    public function testMergeDocumentInvalidMergeSettingsStringInsteadOfBoolean(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mergeData     = $this->getTestTemplateMergeData();
        $mergeSettings = $this->getTestMergeSettings();

        $templateFilename = $this->getTestTemplateFilename();

        self::assertFileExists($templateFilename);

        // value must be boolean
        $mergeSettings['remove_empty_blocks'] = 'invalid';
        $mergeSettings['remove_empty_fields'] = 'invalid';
        $mergeSettings['remove_empty_images'] = 'invalid';

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            '',
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

        self::assertFileExists($templateFilename);

        $mergeSettings['culture'] = 'invalid';

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            '',
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

        self::assertFileExists($templateFilename);

        // value must be timestamp
        $mergeSettings['creation_date']          = -1;
        $mergeSettings['last_modification_date'] = 'invalid';

        $this->reportingCloud->mergeDocument(
            $mergeData,
            ReportingCloud::FILE_FORMAT_PDF,
            '',
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

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);
        self::assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);
        self::assertTrue($response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        self::assertTrue($response);

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

        self::assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);
        self::assertFileExists($tempTemplateFilename);

        $tempTemplateBinary = (string) file_get_contents($tempTemplateFilename);
        $tempTemplateBase64 = base64_encode($tempTemplateBinary);

        $response = $this->reportingCloud->uploadTemplateFromBase64($tempTemplateBase64, $tempTemplateName);
        self::assertTrue($response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        self::assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getDocumentThumbnails">

    public function testGetDocumentThumbnails(): void
    {
        $testDocumentFilename = $this->getTestDocumentFilename();

        self::assertFileExists($testDocumentFilename);

        $response = $this->reportingCloud->getDocumentThumbnails(
            $testDocumentFilename,
            100,
            1,
            1,
            ReportingCloud::FILE_FORMAT_PNG
        );

        self::assertArrayHasKey(0, $response);

        self::assertTrue(mb_strlen($response[0]) > 2048);
    }

    // </editor-fold>

    // <editor-fold desc="getTrackedChanges">

    public function testGetTrackedChanges(): void
    {
        $testDocumentFilename = $this->getTestDocumentTrackedChangesFilename();

        self::assertFileExists($testDocumentFilename);

        $response = $this->reportingCloud->getTrackedChanges(
            $testDocumentFilename
        );

        self::assertArrayHasKey(0, $response);

        self::assertArrayHasKey('change_kind', $response[0]);
        self::assertArrayHasKey('change_time', $response[0]);
        self::assertArrayHasKey('default_highlight_color', $response[0]);
        self::assertArrayHasKey('highlight_color', $response[0]);
        self::assertArrayHasKey('highlight_mode', $response[0]);
        self::assertArrayHasKey('length', $response[0]);
        self::assertArrayHasKey('start', $response[0]);
        self::assertArrayHasKey('id', $response[0]);
        self::assertArrayHasKey('text', $response[0]);
        self::assertArrayHasKey('username', $response[0]);
    }

    // </editor-fold>

    // <editor-fold desc="removeTrackedChange">

    public function testRemoveTrackedChange(): void
    {
        $testDocumentFilename = $this->getTestDocumentTrackedChangesFilename();

        self::assertFileExists($testDocumentFilename);

        $response = $this->reportingCloud->removeTrackedChange(
            $testDocumentFilename,
            1,
            true
        );

        self::assertArrayHasKey('document', $response);
        self::assertArrayHasKey('removed', $response);
    }

    // </editor-fold>

    // </editor-fold>

    // <editor-fold desc="HTTP PUT tests">

    // <editor-fold desc="createApiKey">

    public function testCreateApiKey(): void
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        self::assertNotEmpty($apiKey);
    }

    public function testCreateApiKeyTooManyApiKeys(): void
    {
        $this->expectException(RuntimeException::class);

        $this->deleteAllApiKeys();

        // only 10 API keys are allowed
        for ($i = 1; $i <= 11; $i++) {
            self::assertNotEmpty($this->reportingCloud->createApiKey());
        }
    }
    // </editor-fold>

    // </editor-fold>
}
