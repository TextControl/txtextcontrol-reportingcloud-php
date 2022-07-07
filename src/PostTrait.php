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
 * @copyright © 2022 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud;

use Ctw\Http\HttpMethod;
use Ctw\Http\HttpStatus;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\Filter\Filter;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\ModifiedDocument as ModifiedDocumentPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\TrackedChanges as TrackedChangesPropertyMap;
use TxTextControl\ReportingCloud\Stdlib\FileUtils;

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
     * @return ResponseInterface
     * @throws RuntimeException
     */
    abstract protected function request(string $method, string $uri, array $options): ResponseInterface;

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
     * @throws InvalidArgumentException
     */
    public function uploadTemplateFromBase64(string $data, string $templateName): bool
    {
        Assert::assertBase64Data($data);
        Assert::assertTemplateName($templateName);

        $query = [
            'templateName' => $templateName,
        ];

        $result = $this->post('/templates/upload', $query, $data, HttpStatus::STATUS_CREATED);

        return null === $result;
    }

    /**
     * Upload a template to template storage
     *
     * @param string $templateFilename Template name
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function uploadTemplate(string $templateFilename): bool
    {
        Assert::assertTemplateExtension($templateFilename);
        Assert::assertFilenameExists($templateFilename);

        $templateName = basename($templateFilename);

        $data = FileUtils::read($templateFilename, true);

        return $this->uploadTemplateFromBase64($data, $templateName);
    }

    /**
     * Convert a document on the local file system to a different format
     *
     * @param string $documentFilename Document filename
     * @param string $returnFormat     Return format
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function convertDocument(string $documentFilename, string $returnFormat): string
    {
        Assert::assertDocumentExtension($documentFilename);
        Assert::assertFilenameExists($documentFilename);
        Assert::assertReturnFormat($returnFormat);

        $query = [
            'returnFormat' => $returnFormat,
        ];

        $data = FileUtils::read($documentFilename, true);

        $result = $this->post('/document/convert', $query, $data, HttpStatus::STATUS_OK);

        if (is_string($result) && strlen($result) > 0) {
            $decoded = base64_decode($result, true);
            if (is_string($decoded)) {
                return $decoded;
            }
        }

        return '';
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
     * @return array
     * @throws InvalidArgumentException
     */
    public function mergeDocument(
        array $mergeData,
        string $returnFormat,
        string $templateName = '',
        string $templateFilename = '',
        bool $append = false,
        array $mergeSettings = []
    ): array {

        $query = [];
        $json  = [];

        $json['mergeData'] = $mergeData;

        Assert::assertReturnFormat($returnFormat);
        $query['returnFormat'] = $returnFormat;

        if (strlen($templateName) > 0) {
            Assert::assertTemplateName($templateName);
            $query['templateName'] = $templateName;
        }

        if (strlen($templateFilename) > 0) {
            Assert::assertTemplateExtension($templateFilename);
            Assert::assertFilenameExists($templateFilename);
            $json['template'] = FileUtils::read($templateFilename, true);
        }

        if ($append) {
            //Assert::assertBoolean($append);
            $query['append'] = Filter::filterBooleanToString($append);
        }

        if (count($mergeSettings) > 0) {
            $json['mergeSettings'] = $this->buildMergeSettingsArray($mergeSettings);
        }

        $result = $this->post('/document/merge', $query, $json, HttpStatus::STATUS_OK);

        if (is_array($result)) {
            foreach ($result as $key => $value) {
                $value = base64_decode($value, true);
                assert(is_string($value));
                $result[$key] = $value;
            }
            return $result;
        }

        return [];
    }

    /**
     * Combine documents by appending them, divided by a new section, paragraph or nothing
     *
     * @param array  $documentsData
     * @param string $returnFormat
     * @param array  $documentSettings
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function appendDocument(
        array $documentsData,
        string $returnFormat,
        array $documentSettings = []
    ): string {

        $query = [];
        $json  = [];

        $json['documents'] = $this->buildDocumentsArray($documentsData);

        Assert::assertReturnFormat($returnFormat);
        $query['returnFormat'] = $returnFormat;

        if (count($documentSettings) > 0) {
            $json['documentSettings'] = $this->buildDocumentSettingsArray($documentSettings);
        }

        $result = $this->post('/document/append', $query, $json, HttpStatus::STATUS_OK);

        if (is_string($result) && strlen($result) > 0) {
            $decoded = base64_decode($result, true);
            if (is_string($decoded)) {
                return $decoded;
            }
        }

        return '';
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
     * @return string
     * @throws InvalidArgumentException
     */
    public function findAndReplaceDocument(
        array $findAndReplaceData,
        string $returnFormat,
        string $templateName = '',
        string $templateFilename = '',
        array $mergeSettings = []
    ): string {
        $query = [];
        $json  = [];

        $json['findAndReplaceData'] = $this->buildFindAndReplaceDataArray($findAndReplaceData);

        Assert::assertReturnFormat($returnFormat);
        $query['returnFormat'] = $returnFormat;

        if (strlen($templateName) > 0) {
            Assert::assertTemplateName($templateName);
            $query['templateName'] = $templateName;
        }

        if (strlen($templateFilename) > 0) {
            Assert::assertTemplateExtension($templateFilename);
            Assert::assertFilenameExists($templateFilename);
            $json['template'] = FileUtils::read($templateFilename, true);
        }

        if (count($mergeSettings) > 0) {
            $json['mergeSettings'] = $this->buildMergeSettingsArray($mergeSettings);
        }

        $result = $this->post('/document/findandreplace', $query, $json, HttpStatus::STATUS_OK);

        if (is_string($result) && strlen($result) > 0) {
            $decoded = base64_decode($result, true);
            if (is_string($decoded)) {
                return $decoded;
            }
        }

        return '';
    }

    /**
     * Generate a thumbnail image per page of specified document filename.
     * Return an array of binary data with each record containing one thumbnail.
     *
     * @param string $documentFilename Document filename
     * @param int    $zoomFactor       Zoom factor
     * @param int    $fromPage         From page
     * @param int    $toPage           To page
     * @param string $imageFormat      Image format
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function getDocumentThumbnails(
        string $documentFilename,
        int $zoomFactor,
        int $fromPage,
        int $toPage,
        string $imageFormat
    ): array {

        Assert::assertDocumentThumbnailExtension($documentFilename);
        Assert::assertFilenameExists($documentFilename);
        Assert::assertZoomFactor($zoomFactor);
        Assert::assertPage($fromPage);
        Assert::assertPage($toPage);
        Assert::assertImageFormat($imageFormat);

        $query = [
            'zoomFactor'  => $zoomFactor,
            'fromPage'    => $fromPage,
            'toPage'      => $toPage,
            'imageFormat' => $imageFormat,
        ];

        $data = FileUtils::read($documentFilename, true);

        $result = $this->post('/document/thumbnails', $query, $data, HttpStatus::STATUS_OK);

        if (is_array($result)) {
            foreach ($result as $key => $value) {
                $value = base64_decode($value, true);
                assert(is_string($value));
                $result[$key] = $value;
            }
            return $result;
        }

        return [];
    }

    /**
     * Return the tracked changes in a document.
     *
     * @param string $documentFilename Document filename
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function getTrackedChanges(string $documentFilename): array
    {
        $ret = [];

        $propertyMap = new TrackedChangesPropertyMap();

        Assert::assertDocumentExtension($documentFilename);
        Assert::assertFilenameExists($documentFilename);

        $data = FileUtils::read($documentFilename, true);

        $result = $this->post('/processing/review/trackedchanges', [], $data, HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = $this->buildPropertyMapArray($result, $propertyMap);
            array_walk($ret, function (array &$record): void {
                $key = 'change_time';
                if (isset($record[$key])) {
                    //@todo [20190902] return value of backend DateTime in Zulu timezone
                    //Assert::assertDateTime($record[$key]);
                    $record[$key] = Filter::filterDateTimeToTimestamp($record[$key]);
                }
            });
        }

        return $ret;
    }

    /**
     * Removes a specific tracked change and returns the resulting document.
     *
     * @param string $documentFilename Document filename
     * @param int    $id               The ID of the tracked change that needs to be removed
     * @param bool   $accept           Specifies whether the tracked change should be accepted or not (reject)
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function removeTrackedChange(
        string $documentFilename,
        int $id,
        bool $accept
    ): array {
        $ret = [];

        $propertyMap = new ModifiedDocumentPropertyMap();

        Assert::assertDocumentExtension($documentFilename);
        Assert::assertFilenameExists($documentFilename);

        $query = [
            'id'     => $id,
            'accept' => Filter::filterBooleanToString($accept),
        ];

        $data = FileUtils::read($documentFilename, true);

        $result = $this->post('/processing/review/removetrackedchange', $query, $data, HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = $this->buildPropertyMapArray($result, $propertyMap);
            $key = 'document';
            if (isset($ret[$key]) && is_string($ret[$key])) {
                $ret[$key] = base64_decode($ret[$key], true);
            }
        }

        return $ret;
    }

    /**
     * Execute a POST request via REST client
     *
     * @param string $uri        URI
     * @param array  $query      Query
     * @param mixed  $json       JSON
     * @param int    $statusCode Required HTTP status code for response
     *
     * @return mixed
     */
    private function post(
        string $uri,
        array $query = [],
        $json = '',
        int $statusCode = 0
    ) {

        $ret = '';

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request(HttpMethod::METHOD_POST, $this->uri($uri), $options);

        if ($statusCode === $response->getStatusCode()) {
            $ret = json_decode($response->getBody()->getContents(), true);
        }

        return $ret;
    }

    // </editor-fold>
}
