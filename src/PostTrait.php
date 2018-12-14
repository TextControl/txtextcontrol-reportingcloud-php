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
    /**
     * Abstract Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

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
     *
     * @throws RuntimeException
     */
    abstract protected function request(string $method, string $uri, array $options);

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

    /**
     * POST Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Upload a base64 encoded template to template storage
     *
     * @param string $data         Template encoded as base64
     * @param string $templateName Template name
     *
     * @return bool
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function uploadTemplateFromBase64(string $data, string $templateName): bool
    {
        $ret = false;

        $options = [
            RequestOptions::QUERY => [],
            RequestOptions::JSON  => '',
        ];

        Assert::assertBase64Data($data);
        $options[RequestOptions::JSON] = $data;

        Assert::assertTemplateName($templateName);
        $options[RequestOptions::QUERY]['templateName'] = $templateName;

        $response = $this->request('POST', $this->uri('/templates/upload'), $options);

        if ($response instanceof Response && StatusCode::CREATED === $response->getStatusCode()) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * Upload a template to template storage
     *
     * @param string $templateFilename Template name
     *
     * @return bool
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
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
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function convertDocument(string $documentFilename, string $returnFormat): string
    {
        $ret = '';

        $options = [
            RequestOptions::QUERY => [],
            RequestOptions::JSON  => '',
        ];

        Assert::assertDocumentExtension($documentFilename);
        Assert::filenameExists($documentFilename);
        $json                          = file_get_contents($documentFilename);
        $json                          = base64_encode($json);
        $options[RequestOptions::JSON] = $json;

        Assert::assertReturnFormat($returnFormat);
        $options[RequestOptions::QUERY]['returnFormat'] = $returnFormat;

        $response = $this->request('POST', $this->uri('/document/convert'), $options);

        if ($response instanceof Response && StatusCode::OK === $response->getStatusCode()) {
            $ret = base64_decode($response->getBody()->getContents());
        }

        return $ret;
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
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
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

        $options = [
            RequestOptions::QUERY => [],
            RequestOptions::JSON  => [],
        ];

        Assert::isArray($mergeData);
        $options[RequestOptions::JSON]['mergeData'] = $mergeData;

        Assert::assertReturnFormat($returnFormat);
        $options[RequestOptions::QUERY]['returnFormat'] = $returnFormat;

        if (null !== $templateName) {
            Assert::assertTemplateName($templateName);
            $options[RequestOptions::QUERY]['templateName'] = $templateName;
        }

        if (null !== $templateFilename) {
            Assert::assertTemplateExtension($templateFilename);
            Assert::filenameExists($templateFilename);
            $template                                  = file_get_contents($templateFilename);
            $template                                  = base64_encode($template);
            $options[RequestOptions::JSON]['template'] = $template;
        }

        if (null !== $append) {
            $options[RequestOptions::QUERY]['append'] = Filter::filterBooleanToString($append);
        }

        if (is_array($mergeSettings)) {
            $options[RequestOptions::JSON]['mergeSettings'] = $this->buildMergeSettingsArray($mergeSettings);
        }

        $response = $this->request('POST', $this->uri('/document/merge'), $options);

        if ($response instanceof Response && StatusCode::OK === $response->getStatusCode()) {
            $body = json_decode($response->getBody()->getContents(), true);
            if (is_array($body) && count($body) > 0) {
                $ret = array_map('base64_decode', $body);
            }
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
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function appendDocument(
        array $documentsData,
        string $returnFormat,
        ?array $documentSettings = null
    ): string {

        $ret = '';

        $options = [
            RequestOptions::QUERY => [],
            RequestOptions::JSON  => [],
        ];

        Assert::isArray($documentsData);
        $options[RequestOptions::JSON]['documents'] = $this->buildDocumentsArray($documentsData);

        Assert::assertReturnFormat($returnFormat);
        $options[RequestOptions::QUERY]['returnFormat'] = $returnFormat;

        if (is_array($documentSettings)) {
            $options[RequestOptions::JSON]['documentSettings'] = $this->buildDocumentSettingsArray($documentSettings);
        }

        $response = $this->request('POST', $this->uri('/document/append'), $options);

        if ($response instanceof Response && StatusCode::OK === $response->getStatusCode()) {
            $ret = base64_decode($response->getBody()->getContents());
        }

        return $ret;
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
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function findAndReplaceDocument(
        array $findAndReplaceData,
        string $returnFormat,
        ?string $templateName = null,
        ?string $templateFilename = null,
        ?array $mergeSettings = null
    ): string {

        $ret = '';

        $options = [
            RequestOptions::QUERY => [],
            RequestOptions::JSON  => [],
        ];

        Assert::isArray($findAndReplaceData);
        $options[RequestOptions::JSON]['findAndReplaceData'] = $this->buildFindAndReplaceDataArray($findAndReplaceData);

        Assert::assertReturnFormat($returnFormat);
        $options[RequestOptions::QUERY]['returnFormat'] = $returnFormat;

        if (null !== $templateName) {
            Assert::assertTemplateName($templateName);
            $options[RequestOptions::QUERY]['templateName'] = $templateName;
        }

        if (null !== $templateFilename) {
            Assert::assertTemplateExtension($templateFilename);
            Assert::filenameExists($templateFilename);
            $template                                  = file_get_contents($templateFilename);
            $template                                  = base64_encode($template);
            $options[RequestOptions::JSON]['template'] = $template;
        }

        if (is_array($mergeSettings)) {
            $options[RequestOptions::JSON]['mergeSettings'] = $this->buildMergeSettingsArray($mergeSettings);
        }

        $response = $this->request('POST', $this->uri('/document/findandreplace'), $options);

        if ($response instanceof Response && StatusCode::OK === $response->getStatusCode()) {
            $ret = base64_decode($response->getBody()->getContents());
        }

        return $ret;
    }
}
