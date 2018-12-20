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

namespace TxTextControl\ReportingCloud;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Filter\Filter;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\StatusCode\StatusCode;

/**
 * Trait PostTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait PostTrait
{
    // <editor-fold desc="Abstract methods">

    /**
     * Construct URI with version number
     *
     * @param string $uri URI
     *
     * @return string
     */
    abstract protected function uri(string $uri): string;

    /**
     * Request the URI with options
     *
     * @param string $method  HTTP method
     * @param string $uri     URI
     * @param array  $options Options
     *
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws \TxTextControl\ReportingCloud\Exception\RuntimeException
     */
    abstract protected function request(string $method, string $uri, array $options): Response;

    /**
     * Using passed findAndReplaceData associative array (key-value), build array for backend (list of string arrays)
     *
     * @param array $array FindAndReplaceData array
     *
     * @return array
     */
    abstract protected function buildFindAndReplaceDataArray(array $array): array;

    /**
     * Using passed mergeSettings array, build array for backend
     *
     * @param array $array MergeSettings array
     *
     * @return array
     */
    abstract protected function buildMergeSettingsArray(array $array): array;

    /**
     * Using passed documentsData array, build array for backend
     *
     * @param array $array AppendDocument array
     *
     * @return array
     */
    abstract protected function buildDocumentsArray(array $array): array;

    /**
     * Using passed documentsSettings array, build array for backend
     *
     * @param array $array
     *
     * @return array
     */
    abstract protected function buildDocumentSettingsArray(array $array): array;

    /**
     * Using the passed propertyMap, recursively build array
     *
     * @param array       $array       Array
     * @param PropertyMap $propertyMap PropertyMap
     *
     * @return array
     */
    abstract protected function buildPropertyMapArray(array $array, PropertyMap $propertyMap): array;

    // </editor-fold>

    // <editor-fold desc="Methods">

    /**
     * Upload a base64 encoded template to template storage
     *
     * @param string $data         Template encoded as base64
     * @param string $templateName Template name
     *
     * @return bool
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function uploadTemplateFromBase64(string $data, string $templateName): bool
    {
        Assert::assertBase64Data($data);
        Assert::assertTemplateName($templateName);

        $query = [
            'templateName' => $templateName,
        ];

        $result = $this->post('/templates/upload', $query, $data, StatusCode::CREATED);

        return (null === $result) ? true : false;
    }

    /**
     * Upload a template to template storage
     *
     * @param string $templateFilename Template name
     *
     * @return bool
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function uploadTemplate(string $templateFilename): bool
    {
        Assert::assertTemplateExtension($templateFilename);
        Assert::filenameExists($templateFilename);

        $templateName = basename($templateFilename);

        $data = file_get_contents($templateFilename);
        $data = base64_encode($data);

        return $this->uploadTemplateFromBase64($data, $templateName);
    }

    /**
     * Convert a document on the local file system to a different format
     *
     * @param string $documentFilename Document filename
     * @param string $returnFormat     Return format
     *
     * @return string
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function convertDocument(string $documentFilename, string $returnFormat): string
    {
        Assert::assertDocumentExtension($documentFilename);
        Assert::filenameExists($documentFilename);
        Assert::assertReturnFormat($returnFormat);

        $query = [
            'returnFormat' => $returnFormat,
        ];

        $data = file_get_contents($documentFilename);
        $data = base64_encode($data);

        $result = $this->post('/document/convert', $query, $data, StatusCode::OK);
        settype($result, 'string');

        return (string) base64_decode($result);
    }

    /**
     * Merge data into a template and return an array of binary data.
     * Each record in the array is the binary data of one document
     *
     * @param array       $mergeData        Array of merge data
     * @param string      $returnFormat     Return format
     * @param string|null $templateName     Template name
     * @param string|null $templateFilename Template filename on local file system
     * @param bool|null   $append           Append flag
     * @param array|null  $mergeSettings    Array of merge settings
     *
     * @return array
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function mergeDocument(
        array $mergeData,
        string $returnFormat,
        ?string $templateName = null,
        ?string $templateFilename = null,
        ?bool $append = null,
        ?array $mergeSettings = null
    ): array {
        $ret = [];

        $query = [];
        $json  = [];

        Assert::isArray($mergeData);
        $json['mergeData'] = $mergeData;

        Assert::assertReturnFormat($returnFormat);
        $query['returnFormat'] = $returnFormat;

        if (null !== $templateName) {
            Assert::assertTemplateName($templateName);
            $query['templateName'] = $templateName;
        }

        if (null !== $templateFilename) {
            Assert::assertTemplateExtension($templateFilename);
            Assert::filenameExists($templateFilename);
            $data             = file_get_contents($templateFilename);
            $data             = base64_encode($data);
            $json['template'] = $data;
        }

        if (null !== $append) {
            Assert::boolean($append);
            $query['append'] = Filter::filterBooleanToString($append);
        }

        if (is_array($mergeSettings)) {
            $json['mergeSettings'] = $this->buildMergeSettingsArray($mergeSettings);
        }

        $result = $this->post('/document/merge', $query, $json, StatusCode::OK);

        if (is_array($result)) {
            $ret = array_map('base64_decode', $result);
        }

        return $ret;
    }

    /**
     * Combine documents to appending them, divided by a new section, paragraph or nothing
     *
     * @param array      $documentsData
     * @param string     $returnFormat
     * @param array|null $documentSettings
     *
     * @return string
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function appendDocument(
        array $documentsData,
        string $returnFormat,
        ?array $documentSettings = null
    ): string {
        $query = [];
        $json  = [];

        Assert::isArray($documentsData);
        $json['documents'] = $this->buildDocumentsArray($documentsData);

        Assert::assertReturnFormat($returnFormat);
        $query['returnFormat'] = $returnFormat;

        if (is_array($documentSettings)) {
            $json['documentSettings'] = $this->buildDocumentSettingsArray($documentSettings);
        }

        $result = $this->post('/document/append', $query, $json, StatusCode::OK);
        settype($result, 'string');

        return (string) base64_decode($result);
    }

    /**
     * Perform find and replace in document and return binary data.
     *
     * @param array       $findAndReplaceData Array of find and replace data
     * @param string      $returnFormat       Return format
     * @param string|null $templateName       Template name
     * @param string|null $templateFilename   Template filename on local file system
     * @param array|null  $mergeSettings      Array of merge settings
     *
     * @return string
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function findAndReplaceDocument(
        array $findAndReplaceData,
        string $returnFormat,
        ?string $templateName = null,
        ?string $templateFilename = null,
        ?array $mergeSettings = null
    ): string {
        $query = [];
        $json  = [];

        Assert::isArray($findAndReplaceData);
        $json['findAndReplaceData'] = $this->buildFindAndReplaceDataArray($findAndReplaceData);

        Assert::assertReturnFormat($returnFormat);
        $query['returnFormat'] = $returnFormat;

        if (null !== $templateName) {
            Assert::assertTemplateName($templateName);
            $query['templateName'] = $templateName;
        }

        if (null !== $templateFilename) {
            Assert::assertTemplateExtension($templateFilename);
            Assert::filenameExists($templateFilename);
            $data             = file_get_contents($templateFilename);
            $data             = base64_encode($data);
            $json['template'] = $data;
        }

        if (is_array($mergeSettings)) {
            $json['mergeSettings'] = $this->buildMergeSettingsArray($mergeSettings);
        }

        $result = $this->post('/document/findandreplace', $query, $json, StatusCode::OK);
        settype($result, 'string');

        return (string) base64_decode($result);
    }

    /**
     * Execute a POST request via REST client
     *
     * @param string       $uri        URI
     * @param array        $query      Query
     * @param string|array $json       JSON
     * @param int          $statusCode Required HTTP status code for response
     *
     * @return mixed|null
     */
    private function post(
        string $uri,
        ?array $query = null,
        $json = null,
        ?int $statusCode = null
    ) {
        $ret = '';

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('POST', $this->uri($uri), $options);

        if ($statusCode === $response->getStatusCode()) {
            $ret = json_decode($response->getBody()->getContents(), true);
        }

        return $ret;
    }

    // </editor-fold>
}
