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

use PHPUnit\Framework\Constraint\IsType;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait GetTraitTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait GetTraitTest
{
    // <editor-fold desc="downloadTemplate">

    public function testDownloadTemplate()
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);
        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);
        $this->assertTrue($response);

        $response       = $this->reportingCloud->downloadTemplate($tempTemplateName);
        $responseLength = mb_strlen($response);
        $this->assertNotNull($response);
        $this->assertNotFalse($response);
        $this->assertGreaterThanOrEqual(1024, $responseLength);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testDownloadTemplateInvalidTemplateName()
    {
        // should be templateName and not templateFilename
        $templateFilename = $this->getTestTemplateFilename();

        $this->reportingCloud->downloadTemplate($templateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getAccountSettings">

    public function testGetAccountSettings()
    {
        $response = $this->reportingCloud->getAccountSettings();

        $this->assertArrayHasKey('serial_number', $response);
        $this->assertArrayHasKey('created_documents', $response);
        $this->assertArrayHasKey('uploaded_templates', $response);
        $this->assertArrayHasKey('max_documents', $response);
        $this->assertArrayHasKey('max_templates', $response);
        $this->assertArrayHasKey('valid_until', $response);

        $this->assertTrue(is_string($response['serial_number']));
        $this->assertTrue(is_int($response['created_documents']));
        $this->assertTrue(is_int($response['uploaded_templates']));
        $this->assertTrue(is_int($response['max_documents']));
        $this->assertTrue(is_int($response['max_templates']));
        $this->assertTrue(is_int($response['valid_until']));
    }

    // </editor-fold>

    // <editor-fold desc="getApiKeys">

    public function testGetApiKeys()
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($apiKey);

        $apiKeys = $this->reportingCloud->getApiKeys();
        $this->assertArrayHasKey(0, $apiKeys);
        $this->assertArrayHasKey('key', $apiKeys[0]);
        $this->assertArrayHasKey('active', $apiKeys[0]);
        $this->assertTrue(is_string($apiKeys[0]['key']));
        $this->assertTrue(is_bool($apiKeys[0]['active']));
    }

    // </editor-fold>

    // <editor-fold desc="getAvailableDictionaries">

    public function testGetAvailableDictionaries()
    {
        $filename = Assert::getDictionariesFilename();

        $actual   = $this->reportingCloud->getAvailableDictionaries();
        $expected = include $filename;

        sort($actual);
        sort($expected);

        $this->assertEquals($expected, $actual);
    }

    // </editor-fold>

    // <editor-fold desc="getFontList">

    public function testGetFontList()
    {
        $fonts = $this->reportingCloud->getFontList();

        $this->assertInternalType(IsType::TYPE_ARRAY, $fonts);

        $this->assertContains('Times New Roman', $fonts);
        $this->assertContains('Arial', $fonts);
        $this->assertContains('Courier New', $fonts);

        $this->assertArrayHasKey(0, $fonts);
        $this->assertArrayHasKey(1, $fonts);
        $this->assertArrayHasKey(2, $fonts);
    }

    // </editor-fold>

    // <editor-fold desc="getProofingSuggestions">

    public function testGetProofingSuggestions()
    {
        $response = $this->reportingCloud->getProofingSuggestions('Thiss', 'en_US.dic', 5);

        $this->assertTrue(5 === count($response));

        $this->assertContains('This', $response);
    }

    // </editor-fold>

    // <editor-fold desc="getTemplateCount">

    public function testGetTemplateCount()
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        $this->assertTrue($response);

        $response = $this->reportingCloud->getTemplateCount();

        $this->assertTrue(is_int($response));

        $this->assertGreaterThan(0, $response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getTemplateInfo">

    public function testGetTemplateInfo()
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        $this->assertTrue($response);

        $response = $this->reportingCloud->getTemplateInfo($tempTemplateName);

        $this->assertArrayHasKey('template_name', $response);

        $this->assertArrayHasKey('merge_blocks', $response);

        $this->assertArrayHasKey(0, $response['merge_blocks']);

        $this->assertArrayHasKey('name', $response['merge_blocks'][0]);
        $this->assertArrayHasKey('merge_fields', $response['merge_blocks'][0]);

        $this->assertArrayHasKey(0, $response['merge_blocks'][0]['merge_fields']);

        $this->assertArrayHasKey('date_time_format', $response['merge_blocks'][0]['merge_fields'][0]);
        $this->assertArrayHasKey('numeric_format', $response['merge_blocks'][0]['merge_fields'][0]);
        $this->assertArrayHasKey('preserve_formatting', $response['merge_blocks'][0]['merge_fields'][0]);
        $this->assertArrayHasKey('text', $response['merge_blocks'][0]['merge_fields'][0]);
        $this->assertArrayHasKey('text_after', $response['merge_blocks'][0]['merge_fields'][0]);
        $this->assertArrayHasKey('text_before', $response['merge_blocks'][0]['merge_fields'][0]);

        $this->assertArrayHasKey('merge_fields', $response);

        $this->assertArrayHasKey(0, $response['merge_fields']);

        $this->assertArrayHasKey('date_time_format', $response['merge_fields'][0]);
        $this->assertArrayHasKey('numeric_format', $response['merge_fields'][0]);
        $this->assertArrayHasKey('preserve_formatting', $response['merge_fields'][0]);
        $this->assertArrayHasKey('text', $response['merge_fields'][0]);
        $this->assertArrayHasKey('text_after', $response['merge_fields'][0]);
        $this->assertArrayHasKey('text_before', $response['merge_fields'][0]);

        $this->assertArrayHasKey('user_document_properties', $response);

        $this->assertInternalType(IsType::TYPE_ARRAY, $response['user_document_properties']);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getTemplateList">

    public function testGetTemplateList()
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        $this->assertTrue($response);

        $response = $this->reportingCloud->getTemplateList();

        $this->assertArrayHasKey(0, $response);

        $this->assertArrayHasKey('template_name', $response[0]);
        $this->assertArrayHasKey('modified', $response[0]);
        $this->assertArrayHasKey('size', $response[0]);

        $this->assertTrue(is_string($response[0]['template_name']));
        $this->assertTrue(is_int($response[0]['modified']));
        $this->assertTrue(is_int($response[0]['size']));

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    // </editor-fold>

    // <editor-fold desc="getTemplatePageCount">

    public function testGetTemplatePageCount()
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        $this->assertTrue($response);

        $response = $this->reportingCloud->getTemplatePageCount($tempTemplateName);

        $this->assertSame(1, $response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetTemplatePageCountInvalidTemplateName()
    {
        $this->reportingCloud->getTemplatePageCount('sample_invoice.xx');
    }


    // </editor-fold>

    // <editor-fold desc="getTemplateThumbnails">

    public function testGetTemplateThumbnails()
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        $this->assertTrue($response);

        $response = $this->reportingCloud->getTemplateThumbnails($tempTemplateName, 100, 1, 1, 'PNG');

        $this->assertArrayHasKey(0, $response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetTemplateThumbnailsInvalidTemplateName()
    {
        $this->reportingCloud->getTemplateThumbnails('sample_invoice.xx', 100, 1, 1, 'PNG');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetTemplateThumbnailsInvalidZoomFactor()
    {
        $this->reportingCloud->getTemplateThumbnails('sample_invoice.tx', -1, 1, 1, 'PNG');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetTemplateThumbnailsInvalidFromPage()
    {
        $this->reportingCloud->getTemplateThumbnails('sample_invoice.tx', 100, -1, 1, 'PNG');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetTemplateThumbnailsInvalidToPage()
    {
        $this->reportingCloud->getTemplateThumbnails('sample_invoice.tx', 100, 1, -1, 'PNG');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetTemplateThumbnailsInvalidImageFormat()
    {
        $this->reportingCloud->getTemplateThumbnails('sample_invoice.tx', 100, 1, 1, 'XXX');
    }

    // </editor-fold>

    // <editor-fold desc="proofingCheck">

    public function testProofingCheck()
    {
        $response = $this->reportingCloud->proofingCheck('Thiss is a dog', 'en_US.dic');

        $this->assertArrayHasKey(0, $response);

        $response = $response[0];

        $this->assertArrayHasKey('length', $response);
        $this->assertArrayHasKey('start', $response);
        $this->assertArrayHasKey('text', $response);
        $this->assertArrayHasKey('is_duplicate', $response);
        $this->assertArrayHasKey('language', $response);

        $this->assertEquals(5, $response['length']);
        $this->assertEquals(0, $response['start']);
        $this->assertEquals('Thiss', $response['text']);
        $this->assertEquals(false, $response['is_duplicate']);
        $this->assertEquals('en_US.dic', $response['language']);
    }

    // </editor-fold>

    // <editor-fold desc="templateExists">

    public function testTemplateExists()
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);

        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);

        $this->assertTrue($response);

        $response = $this->reportingCloud->templateExists($tempTemplateName);

        $this->assertTrue($response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        $response = $this->reportingCloud->templateExists($tempTemplateName);

        $this->assertFalse($response);

        unlink($tempTemplateFilename);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testTemplateExistsInvalidTemplateName()
    {
        $this->reportingCloud->templateExists('sample_invoice.xx');
    }

    // </editor-fold>
}
