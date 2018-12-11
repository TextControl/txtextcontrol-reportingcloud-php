<?php

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
use TxTextControl\ReportingCloud\Filter\StaticFilter;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

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
    abstract protected function uri($uri);

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
    abstract protected function request($method, $uri, $options);

    /**
     * Using passed findAndReplaceData associative array (key-value), build array for backend (list of string arrays)
     *
     * @param array $array FindAndReplaceData array
     *
     * @return array
     */
    abstract protected function buildFindAndReplaceDataArray(array $array);

    /**
     * Using passed mergeSettings array, build array for backend
     *
     * @param array $array MergeSettings array
     *
     * @return array
     */
    abstract protected function buildMergeSettingsArray(array $array);

    /**
     * Using passed documentsData array, build array for backend
     *
     * @param array $array AppendDocument array
     *
     * @return array
     */
    abstract protected function buildDocumentsArray(array $array);

    /**
     * Using passed documentsSettings array, build array for backend
     *
     * @param array $array
     *
     * @return array
     */
    abstract protected function buildDocumentSettingsArray(array $array);

    /**
     * Using the passed propertyMap, recursively build array
     *
     * @param array       $array       Array
     * @param PropertyMap $propertyMap PropertyMap
     *
     * @return array
     */
    abstract protected function buildPropertyMapArray(array $array, PropertyMap $propertyMap);

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
     * @throws RuntimeException
     */
    public function uploadTemplateFromBase64($data, $templateName)
    {
        $ret = false;

        StaticValidator::execute($data, 'Base64Data');
        StaticValidator::execute($templateName, 'TemplateExtension');

        $options = [
            RequestOptions::QUERY => [
                'templateName' => $templateName,
            ],
            RequestOptions::JSON  => $data,
        ];

        $response = $this->request('POST', $this->uri('/templates/upload'), $options);

        if ($response instanceof Response && 201 === $response->getStatusCode()) {
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
     * @throws RuntimeException
     */
    public function uploadTemplate($templateFilename)
    {
        StaticValidator::execute($templateFilename, 'TemplateExtension');
        StaticValidator::execute($templateFilename, 'FileExists');

        $templateFilename = realpath($templateFilename);
        $templateName     = basename($templateFilename);

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
     * @return bool|null|string
     * @throws RuntimeException
     */
    public function convertDocument($documentFilename, $returnFormat)
    {
        $ret = null;

        StaticValidator::execute($documentFilename, 'DocumentExtension');
        StaticValidator::execute($documentFilename, 'FileExists');
        StaticValidator::execute($returnFormat, 'ReturnFormat');

        $documentFilename = realpath($documentFilename);

        $json = file_get_contents($documentFilename);
        $json = base64_encode($json);

        $options = [
            RequestOptions::QUERY => [
                'returnFormat' => $returnFormat,
            ],
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('POST', $this->uri('/document/convert'), $options);

        if ($response instanceof Response && 200 === $response->getStatusCode()) {
            $ret = base64_decode($response->getBody());
        }

        return $ret;
    }

    /**
     * Merge data into a template and return an array of binary data.
     * Each record in the array is the binary data of one document
     *
     * @param array  $mergeData        Array of merge data
     * @param string $returnFormat     Return format
     * @param string $templateName     Template name
     * @param string $templateFilename Template filename on local file system
     * @param bool   $append           Append flag
     * @param array  $mergeSettings    Array of merge settings
     *
     * @return array|null
     * @throws RuntimeException
     * @throws \Zend\Filter\Exception\ExceptionInterface
     */
    public function mergeDocument(
        $mergeData,
        $returnFormat,
        $templateName = null,
        $templateFilename = null,
        $append = null,
        $mergeSettings = []
    ) {
        $ret = null;

        StaticValidator::execute($mergeData, 'TypeArray');
        StaticValidator::execute($returnFormat, 'ReturnFormat');

        if (null !== $templateName) {
            StaticValidator::execute($templateName, 'TemplateName');
        }

        if (null !== $templateFilename) {
            StaticValidator::execute($templateFilename, 'TemplateExtension');
            StaticValidator::execute($templateFilename, 'FileExists');
            $templateFilename = realpath($templateFilename);
        }

        if (null !== $append) {
            $append = StaticFilter::execute($append, 'BooleanToString');
        }

        StaticValidator::execute($mergeSettings, 'TypeArray');

        $query = [
            'returnFormat' => $returnFormat,
            'append'       => $append,
        ];

        if (null !== $templateName) {
            $query['templateName'] = $templateName;
        }

        $json = [
            'mergeData' => $mergeData,
        ];

        if (null !== $templateFilename) {
            $template         = file_get_contents($templateFilename);
            $template         = base64_encode($template);
            $json['template'] = $template;
        }

        if (count($mergeSettings) > 0) {
            $json['mergeSettings'] = $this->buildMergeSettingsArray($mergeSettings);
        }

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('POST', $this->uri('/document/merge'), $options);

        if ($response instanceof Response && 200 === $response->getStatusCode()) {
            $body = json_decode($response->getBody(), true);
            if (is_array($body) && count($body) > 0) {
                $ret = array_map('base64_decode', $body);
            }
        }

        return $ret;
    }

    /**
     * Combine documents to appending them, divided by a new section, paragraph or nothing
     *
     * @param array  $documentsData
     * @param string $returnFormat
     * @param array  $documentSettings
     *
     * @return bool|null|string
     */
    public function appendDocument($documentsData, $returnFormat, $documentSettings = [])
    {
        $ret = null;

        StaticValidator::execute($documentsData, 'TypeArray');
        StaticValidator::execute($returnFormat, 'ReturnFormat');
        StaticValidator::execute($documentSettings, 'TypeArray');

        $query = [
            'returnFormat' => $returnFormat,
        ];

        $json = [
            'documents' => $this->buildDocumentsArray($documentsData),
        ];

        if (count($documentSettings) > 0) {
            $json['documentSettings'] = $this->buildDocumentSettingsArray($documentSettings);
        }

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('POST', $this->uri('/document/append'), $options);

        if ($response instanceof Response && 200 === $response->getStatusCode()) {
            $ret = base64_decode($response->getBody());
        }

        return $ret;
    }

    /**
     * Perform find and replace in document and return binary data.
     *
     * @param array  $findAndReplaceData Array of find and replace data
     * @param string $returnFormat       Return format
     * @param string $templateName       Template name
     * @param string $templateFilename   Template filename on local file system
     * @param array  $mergeSettings      Array of merge settings
     *
     * @return bool|null|string
     * @throws RuntimeException
     */
    public function findAndReplaceDocument(
        $findAndReplaceData,
        $returnFormat,
        $templateName = null,
        $templateFilename = null,
        $mergeSettings = []
    ) {
        $ret = null;

        StaticValidator::execute($findAndReplaceData, 'TypeArray');
        StaticValidator::execute($returnFormat, 'ReturnFormat');

        if (null !== $templateName) {
            StaticValidator::execute($templateName, 'TemplateName');
        }

        if (null !== $templateFilename) {
            StaticValidator::execute($templateFilename, 'TemplateExtension');
            StaticValidator::execute($templateFilename, 'FileExists');
            $templateFilename = realpath($templateFilename);
        }

        StaticValidator::execute($mergeSettings, 'TypeArray');

        $query = [
            'returnFormat' => $returnFormat,
        ];

        if (null !== $templateName) {
            $query['templateName'] = $templateName;
        }

        $json = [
            'findAndReplaceData' => $this->buildFindAndReplaceDataArray($findAndReplaceData),
        ];

        if (null !== $templateFilename) {
            $template         = file_get_contents($templateFilename);
            $template         = base64_encode($template);
            $json['template'] = $template;
        }

        if (count($mergeSettings) > 0) {
            $json['mergeSettings'] = $this->buildMergeSettingsArray($mergeSettings);
        }

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('POST', $this->uri('/document/findandreplace'), $options);

        if ($response instanceof Response && 200 === $response->getStatusCode()) {
            $ret = base64_decode($response->getBody());
        }

        return $ret;
    }
}
