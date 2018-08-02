<?php

namespace TxTextControlTest\ReportingCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PHPUnit_Framework_Constraint_IsType as PHPUnit_IsType;
use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Validator\ReturnFormat as ReturnFormatValidator;

class ReportingCloudTest extends PHPUnit_Framework_TestCase
{
    protected $reportingCloud;

    public function setUp()
    {
        $this->reportingCloud = new ReportingCloud();

        $this->assertNotEmpty(Helper::username());
        $this->assertNotEmpty(Helper::password());

        $this->reportingCloud->setUsername(Helper::username());
        $this->reportingCloud->setPassword(Helper::password());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAuthenticationWithoutCredentials()
    {
        $reportingCloud = new ReportingCloud();

        $reportingCloud->setUsername(null);
        $reportingCloud->setPassword(null);
        $reportingCloud->setApiKey(null);

        $reportingCloud->getFontList();
    }

    public function testAuthenticationWithApiKey()
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($apiKey);

        $reportingCloud = new ReportingCloud();

        $reportingCloud->setTest(true);
        $reportingCloud->setApiKey($apiKey);

        $this->assertEquals($apiKey, $reportingCloud->getApiKey());
        $this->assertContains('Times New Roman', $reportingCloud->getFontList());

        $this->deleteAllApiKeys();

        unset($reportingCloud);
    }

    public function testConstructorOptions()
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

        $this->assertSame('phpunit-username', $reportingCloud->getUsername());
        $this->assertSame('phpunit-password', $reportingCloud->getPassword());
        $this->assertSame('https://api.example.com', $reportingCloud->getBaseUri());
        $this->assertSame(100, $reportingCloud->getTimeout());
        $this->assertSame('v1', $reportingCloud->getVersion());

        $this->assertTrue($reportingCloud->getDebug());
        $this->assertTrue($reportingCloud->getTest());

        unset($reportingCloud);
    }

    public function testSetGetProperties()
    {
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');
        $this->reportingCloud->setBaseUri('https://api.example.com');
        $this->reportingCloud->setTimeout(100);
        $this->reportingCloud->setVersion('v1');
        $this->reportingCloud->setDebug(true);
        $this->reportingCloud->setTest(true);

        $this->assertSame('phpunit-username', $this->reportingCloud->getUsername());
        $this->assertSame('phpunit-password', $this->reportingCloud->getPassword());
        $this->assertSame('https://api.example.com', $this->reportingCloud->getBaseUri());
        $this->assertSame(100, $this->reportingCloud->getTimeout());
        $this->assertSame('v1', $this->reportingCloud->getVersion());

        $this->assertTrue($this->reportingCloud->getDebug());
        $this->assertTrue($this->reportingCloud->getTest());
    }

    public function testGetClientInstanceOf()
    {
        $this->assertInstanceOf('GuzzleHttp\Client', $this->reportingCloud->getClient());
    }

    public function testDefaultProperties()
    {
        $reportingCloud = new ReportingCloud();

        $this->assertNull($reportingCloud->getUsername());
        $this->assertNull($reportingCloud->getPassword());

        $this->assertSame('https://api.reporting.cloud', $reportingCloud->getBaseUri());
        $this->assertSame(120, $reportingCloud->getTimeout());
        $this->assertSame('v1', $reportingCloud->getVersion());

        $this->assertFalse($reportingCloud->getDebug());

        unset($reportingCloud);
    }

    public function testResponseStatusCodeOnNonSsl()
    {
        $baseUriHost = parse_url($this->reportingCloud->getBaseUri(), PHP_URL_HOST);

        $this->assertNotEmpty($baseUriHost);

        $uri = sprintf('http://%s', $baseUriHost);

        try {
            $client = new Client();
            $client->request('GET', $uri);
        } catch (ClientException $e) {
            $this->assertSame(404, $e->getResponse()->getStatusCode());
        }
    }

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

    public function testApiKeyMaintenanceMethods()
    {
        $this->deleteAllApiKeys();

        $key = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($key);

        $apiKeys = $this->reportingCloud->getApiKeys();
        $this->assertArrayHasKey(0, $apiKeys);
        $this->assertArrayHasKey('key', $apiKeys[0]);
        $this->assertArrayHasKey('active', $apiKeys[0]);
        $this->assertInternalType(PHPUnit_IsType::TYPE_STRING, $apiKeys[0]['key']);
        $this->assertInternalType(PHPUnit_IsType::TYPE_BOOL, $apiKeys[0]['active']);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testTooManyApiKeys()
    {
        $this->deleteAllApiKeys();

        // only 10 API keys are allowed
        for ($i = 1; $i <= 11; $i++) {
            $this->assertNotEmpty($this->reportingCloud->createApiKey());
        }
    }

    public function testGetAvailableDictionaries()
    {
        $filename = realpath(__DIR__ . '/../data/dictionaries.php');

        $actual   = $this->reportingCloud->getAvailableDictionaries();
        $expected = include $filename;

        sort($actual);
        sort($expected);

        $this->assertEquals($expected, $actual);
    }

    public function testGetProofingSuggestions()
    {
        $response = $this->reportingCloud->getProofingSuggestions('Thiss', 'en_US.dic', 5);

        $this->assertTrue(5 === count($response));

        $this->assertContains('This', $response);
    }

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

        $this->assertInternalType(PHPUnit_IsType::TYPE_ARRAY, $response['user_document_properties']);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

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

        $this->assertTrue(is_integer($response));

        $this->assertGreaterThan(0, $response);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testTemplateExistsInvalidTemplateName()
    {
        $this->reportingCloud->templateExists('sample_invoice.xx');
    }

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
    public function testGetTemplatePageCountInvalidTemplateName()
    {
        $this->reportingCloud->getTemplatePageCount('sample_invoice.xx');
    }

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

        $this->assertInternalType(PHPUnit_IsType::TYPE_STRING, $response[0]['template_name']);
        $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $response[0]['modified']);
        $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $response[0]['size']);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    public function testGetFontList()
    {
        $fonts = $this->reportingCloud->getFontList();

        $this->assertInternalType(PHPUnit_IsType::TYPE_ARRAY, $fonts);

        $this->assertContains('Times New Roman', $fonts);
        $this->assertContains('Arial', $fonts);
        $this->assertContains('Courier New', $fonts);

        $this->assertArrayHasKey(0, $fonts);
        $this->assertArrayHasKey(1, $fonts);
        $this->assertArrayHasKey(2, $fonts);
    }

    public function testGetAccountSettings()
    {
        $response = $this->reportingCloud->getAccountSettings();

        $this->assertArrayHasKey('serial_number', $response);
        $this->assertArrayHasKey('created_documents', $response);
        $this->assertArrayHasKey('uploaded_templates', $response);
        $this->assertArrayHasKey('max_documents', $response);
        $this->assertArrayHasKey('max_templates', $response);
        $this->assertArrayHasKey('valid_until', $response);

        $this->assertInternalType(PHPUnit_IsType::TYPE_STRING, $response['serial_number']);
        $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $response['created_documents']);
        $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $response['uploaded_templates']);
        $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $response['max_documents']);
        $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $response['max_templates']);
        $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $response['valid_until']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidDocumentFilenameUnsupportedExtension()
    {
        $this->reportingCloud->convertDocument('/invalid/path/document.xxx', 'PDF');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidDocumentFilenameNoExtension()
    {
        $this->reportingCloud->convertDocument('/invalid/path/document', 'PDF');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidDocumentFilenameNoFile()
    {
        $this->reportingCloud->convertDocument('/invalid/path/document/', 'PDF');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidDocumentFilename()
    {
        $this->reportingCloud->convertDocument('/invalid/path/document.doc', 'PDF');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConvertDocumentInvalidReturnFormat()
    {
        $documentFilename = $this->getTestTemplateFilename();

        $this->reportingCloud->convertDocument($documentFilename, 'XXX');
    }

    public function testConvertDocument()
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
    public function testMergeDocumentInvalidReturnFormat()
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'X');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateName()
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', '../invalid_template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateFilenameUnsupportedExtension()
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, '/invalid/path/template.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateFilenameNoExtension()
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, '/invalid/path/template');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateFilenameNoFile()
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, '/invalid/path/template/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidTemplateFilename()
    {
        $mergeData = $this->getTestTemplateMergeData();

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, '/invalid/path/template.doc');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidAppend()
    {
        $mergeData        = $this->getTestTemplateMergeData();
        $templateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($templateFilename);

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, $templateFilename, 1);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidMergeSettingsIntegerInsteadOfArray()
    {
        $mergeData        = $this->getTestTemplateMergeData();
        $templateFilename = $this->getTestTemplateFilename();

        $this->assertFileExists($templateFilename);

        $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, $templateFilename, true, 1);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMergeDocumentInvalidMergeSettingsStringInsteadOfBoolean()
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
    public function testMergeDocumentInvalidCultureValue()
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
    public function testMergeDocumentInvalidMergeSettingsTimestampValues()
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

    public function testMergeDocumentWithTemplateName()
    {
        $returnFormats = $this->getTestReturnFormats();

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
                $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $key);
                $this->assertGreaterThanOrEqual(1024, mb_strlen($page));
            }
        }

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);
    }

    public function testMergeDocumentWithTemplateFilename()
    {
        $returnFormats = $this->getTestReturnFormats();

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
                $this->assertInternalType(PHPUnit_IsType::TYPE_INT, $key);
                $this->assertGreaterThanOrEqual(1024, mb_strlen($page));
            }
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidReturnFormat()
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'X');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateName()
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', '../invalid_template.tx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateFilenameUnsupportedExtension()
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, '/invalid/path/template.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateFilenameNoExtension()
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, '/invalid/path/template');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateFilenameNoFile()
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, '/invalid/path/template/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidTemplateFilename()
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, '/invalid/path/template.doc');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidMergeSettingsIntegerInsteadOfArray()
    {
        $findAndReplaceData = $this->getTestTemplateFindAndReplaceData();
        $templateFilename   = $this->getTestTemplateFindAndReplaceFilename();

        $this->assertFileExists($templateFilename);

        $this->reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, $templateFilename, 1);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindAndReplaceDocumentInvalidMergeSettingsStringInsteadOfBoolean()
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
    public function testFindAndReplaceDocumentInvalidMergeSettingsTimestampValues()
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

    public function testFindAndReplaceDocumentWithTemplateName()
    {
        $returnFormats = $this->getTestReturnFormats();

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

    public function testFindAndReplaceDocumentWithTemplateFilename()
    {
        $returnFormats = $this->getTestReturnFormats();

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

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadTemplateInvalidTemplateFilenameUnsupportedExtension()
    {
        $this->reportingCloud->uploadTemplate('/invalid/path/document.xxx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadTemplateInvalidTemplateFilenameNoExtension()
    {
        $this->reportingCloud->uploadTemplate('/invalid/path/document');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadTemplateInvalidTemplateFilenameNoFile()
    {
        $this->reportingCloud->uploadTemplate('/invalid/path/document/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadTemplateInvalidTemplateFilename()
    {
        $this->reportingCloud->uploadTemplate('/invalid/path/template.doc');
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

    /**
     * @expectedException InvalidArgumentException
     */
    public function testDeleteTemplateInvalidTemplateName()
    {
        // should be templateName and not templateFilename
        $templateFilename = $this->getTestTemplateFilename();

        $this->reportingCloud->deleteTemplate($templateFilename);
    }

    public function testUploadDownloadDeleteTemplate()
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
        $this->assertGreaterThan(1024, $responseLength);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);

        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRequestRuntimeException()
    {
        $this->reportingCloud->deleteTemplate('invalid-template.tx');
    }

    protected function getTempDocumentFilename()
    {
        $ret = sprintf('%s/test_document_%d.docx', sys_get_temp_dir(), rand(0, PHP_INT_MAX));

        return $ret;
    }

    protected function getTestTemplateFilename()
    {
        $ret = sprintf('%s/test_template.tx', realpath(__DIR__ . '/../data'));

        return $ret;
    }

    protected function getTestDocumentFilename()
    {
        $ret = sprintf('%s/test_document.docx', realpath(__DIR__ . '/../data'));

        return $ret;
    }

    protected function getTestTemplateFindAndReplaceFilename()
    {
        $ret = sprintf('%s/test_find_and_replace.tx', realpath(__DIR__ . '/../data'));

        return $ret;
    }

    protected function getTempTemplateFilename()
    {
        $ret = sprintf('%s/test_template_%d.tx', sys_get_temp_dir(), rand(0, PHP_INT_MAX));

        return $ret;
    }

    protected function getTestTemplateMergeData()
    {
        $ret = [
            [
                'yourcompany_companyname' => 'Text Control, LLC',
                'yourcompany_zip'         => '28226',
                'yourcompany_city'        => 'Charlotte',
                'yourcompany_street'      => '6926 Shannon Willow Rd, Suite 400',
                'yourcompany_phone'       => '704 544 7445',
                'yourcompany_fax'         => '704-542-0936',
                'yourcompany_url'         => 'www.textcontrol.com',
                'yourcompany_email'       => 'sales@textcontrol.com',
                'invoice_no'              => '778723',
                'billto_name'             => 'Joey Montana',
                'billto_companyname'      => 'Montana, LLC',
                'billto_customerid'       => '123',
                'billto_zip'              => '27878',
                'billto_city'             => 'Charlotte',
                'billto_street'           => '1 Washington Dr',
                'billto_phone'            => '887 267 3356',
                'payment_due'             => '20/1/2016',
                'payment_terms'           => 'NET 30',
                'salesperson_name'        => 'Mark Frontier',
                'delivery_date'           => '20/1/2016',
                'delivery_method'         => 'Ground',
                'delivery_method_terms'   => 'NET 30',
                'recipient_name'          => 'Joey Montana',
                'recipient_companyname'   => 'Montana, LLC',
                'recipient_zip'           => '27878',
                'recipient_city'          => 'Charlotte',
                'recipient_street'        => '1 Washington Dr',
                'recipient_phone'         => '887 267 3356',
                'total_discount'          => 532.60,
                'total_sub'               => 7673.4,
                'total_tax'               => 537.138,
                'total'                   => 8210.538,
                'item'                    => [
                    [
                        'qty'              => 1,
                        'item_no'          => 1,
                        'item_description' => 'Item description 1',
                        'item_unitprice'   => 2663,
                        'item_discount'    => 20,
                        'item_total'       => 2130.40,
                    ],
                    [
                        'qty'              => 1,
                        'item_no'          => 2,
                        'item_description' => 'Item description 2',
                        'item_unitprice'   => 5543,
                        'item_discount'    => 0,
                        'item_total'       => 5543,
                    ],
                ],
            ],
        ];

        // copy data 4 times
        // total record sets = 5

        for ($i = 0; $i < 4; $i++) {
            array_push($ret, $ret[0]);
        }

        return $ret;
    }

    protected function getTestTemplateFindAndReplaceData()
    {
        $ret = [
            '%%FIELD1%%' => 'hello field 1',
            '%%FIELD2%%' => 'hello field 2',
        ];

        return $ret;
    }

    protected function getTestReturnFormats()
    {
        $validator = new ReturnFormatValidator();

        $ret = $validator->getHaystack();

        return $ret;
    }

    protected function getTestMergeSettings()
    {
        $ret = [
            'creation_date'              => time(),
            'last_modification_date'     => time(),
            'remove_empty_blocks'        => true,
            'remove_empty_fields'        => true,
            'remove_empty_images'        => true,
            'remove_trailing_whitespace' => true,
            'author'                     => 'James Henry Trotter',
            'creator_application'        => 'The Giant Peach',
            'document_subject'           => 'The Old Green Grasshopper',
            'document_title'             => 'James and the Giant Peach',
            'user_password'              => '123456789',
        ];

        return $ret;
    }

    protected function deleteAllApiKeys()
    {
        $apiKeys = $this->reportingCloud->getApiKeys();
        if (is_array($apiKeys)) {
            foreach ($apiKeys as $apiKey) {
                $this->assertArrayHasKey('key', $apiKey);
                $this->assertArrayHasKey('active', $apiKey);
                $this->reportingCloud->deleteApiKey($apiKey['key']);
            }
        }

        $apiKeys = $this->reportingCloud->getApiKeys();
        $this->assertNull($apiKeys);
    }
}
