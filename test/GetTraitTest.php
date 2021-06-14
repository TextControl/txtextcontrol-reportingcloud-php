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
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait GetTraitTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait GetTraitTest
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
     *
     */
    abstract protected function deleteAllApiKeys(): void;

    // </editor-fold>

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
}
