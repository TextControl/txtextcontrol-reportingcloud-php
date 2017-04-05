<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Filter\StaticFilter;
use TxTextControl\ReportingCloud\PropertyMap\AccountSettings as AccountSettingsPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\TemplateInfo as TemplateInfoPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\TemplateList as TemplateListPropertyMap;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

/**
 * ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloud extends AbstractReportingCloud
{

    /**
     * GET methods
     * =================================================================================================================
     */

    /**
     * Return an array of merge blocks and merge fields in a template file in template storage.
     *
     * @param string  $templateName Template name
     *
     * @throws InvalidArgumentException
     *
     * @return array|null
     */
    public function getTemplateInfo($templateName)
    {
        $ret = null;

        $propertyMap = new TemplateInfoPropertyMap();

        StaticValidator::execute($templateName, 'TemplateName');

        $query = [
            'templateName' => $templateName,
        ];

        $records = $this->get('/templates/info', $query);

        if (is_array($records) && count($records) > 0) {
            $ret = $this->buildPropertyMapArray($records, $propertyMap);
        }

        return $ret;
    }

    /**
     * Return an array of binary data.
     * Each record in the array is the binary data of a thumbnail image
     *
     * @param string  $templateName Template name
     * @param integer $zoomFactor   Zoom factor
     * @param integer $fromPage     From page
     * @param integer $toPage       To page
     * @param string  $imageFormat  Image format
     *
     * @throws InvalidArgumentException
     *
     * @return array|null
     */
    public function getTemplateThumbnails($templateName, $zoomFactor, $fromPage, $toPage, $imageFormat)
    {
        $ret = null;

        StaticValidator::execute($templateName, 'TemplateName');
        StaticValidator::execute($zoomFactor  , 'ZoomFactor');
        StaticValidator::execute($fromPage    , 'Page');
        StaticValidator::execute($toPage      , 'Page');
        StaticValidator::execute($imageFormat , 'ImageFormat');

        $query = [
            'templateName' => $templateName,
            'zoomFactor'   => $zoomFactor,
            'fromPage'     => $fromPage,
            'toPage'       => $toPage,
            'imageFormat'  => $imageFormat,
        ];

        $records = $this->get('/templates/thumbnails', $query);

        if (is_array($records) && count($records) > 0) {
            $ret = array_map('base64_decode', $records);
        }

        return $ret;
    }

    /**
     * Return the number of templates in template storage
     *
     * @return integer
     */
    public function getTemplateCount()
    {
        return (integer) $this->get('/templates/count');
    }

    /**
     * Return an array properties for the templates in template storage
     *
     * @return array|null
     */
    public function getTemplateList()
    {
        $ret = null;

        $propertyMap = new TemplateListPropertyMap();

        $records = $this->get('/templates/list');

        if (is_array($records) && count($records) > 0) {
            $ret = $this->buildPropertyMapArray($records, $propertyMap);
            array_walk($ret, function (&$record) {
                $key = 'modified';
                if (isset($record[$key])) {
                    $record[$key] = StaticFilter::execute($record[$key], 'DateTimeToTimestamp');
                }
            });
        }

        return $ret;
    }

    /**
     * Return the number of pages in a template in template storage
     *
     * @param string $templateName Template name
     *
     * @throws InvalidArgumentException
     *
     * @return integer
     */
    public function getTemplatePageCount($templateName)
    {
        StaticValidator::execute($templateName, 'TemplateName');

        $query = [
            'templateName' => $templateName,
        ];

        return (integer) $this->get('/templates/pagecount', $query);
    }

    /**
     * Return true, if the template exists in template storage
     *
     * @param string $templateName Template name
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function templateExists($templateName)
    {
        StaticValidator::execute($templateName, 'TemplateName');

        $query = [
            'templateName' => $templateName,
        ];

        return (boolean) $this->get('/templates/exists', $query);
    }

    /**
     * Return an array of available fonts on the Reporting Cloud service
     *
     * @return array|null
     */
    public function getFontList()
    {
        $ret = null;

        $fonts = $this->get('/fonts/list');

        if (is_array($fonts) && count($fonts) > 0) {
            $ret = array_map('trim', $fonts);
        }

        return $ret;
    }

    /**
     * Return an array properties for the ReportingCloud account
     *
     * @return array|null
     */
    public function getAccountSettings()
    {
        $ret = null;

        $propertyMap = new AccountSettingsPropertyMap();

        $records = $this->get('/account/settings');

        if (is_array($records) && count($records) > 0) {
            $ret = $this->buildPropertyMapArray($records, $propertyMap);
            $key = 'valid_until';
            if ($ret[$key]) {
                $ret[$key] = StaticFilter::execute($ret[$key], 'DateTimeToTimestamp');
            }
        }

        return $ret;
    }

    /**
     * Download the binary data of a template from template storage
     *
     * @param string $templateName Template name
     *
     * @throws InvalidArgumentException
     *
     * @return null|resource
     */
    public function downloadTemplate($templateName)
    {
        $ret = null;

        StaticValidator::execute($templateName, 'TemplateName');

        $query = [
            'templateName' => $templateName,
        ];

        $data = $this->get('/templates/download', $query);

        if (null !== $data) {
            $ret = base64_decode($data);
        }

        return $ret;
    }

    /**
     * Execute a GET request via REST client
     *
     * @param string $uri   URI
     * @param array  $query Query
     *
     * @return mixed|null
     */
    protected function get($uri, $query = [])
    {
        $ret = null;

        $options = [
            RequestOptions::QUERY => $query,
        ];

        $response = $this->request('GET', $this->uri($uri), $options);

        if ($response instanceof Response && 200 === $response->getStatusCode()) {
            $ret  = json_decode($response->getBody(), true);
        }

        return $ret;
    }


    /**
     * POST methods
     * =================================================================================================================
     */

    /**
     * Upload a template to template storage
     *
     * @param string $templateFilename Template name
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function uploadTemplate($templateFilename)
    {
        $ret = false;

        StaticValidator::execute($templateFilename, 'TemplateExtension');
        StaticValidator::execute($templateFilename, 'FileExists');

        $templateFilename = realpath($templateFilename);
        $templateName     = basename($templateFilename);

        $query = [
            'templateName' => $templateName,
        ];

        $json = file_get_contents($templateFilename);
        $json = base64_encode($json);

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('POST', $this->uri('/templates/upload'), $options);

        if ($response instanceof Response && 201 === $response->getStatusCode()) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * Convert a document on the local file system to a different format
     *
     * @param string $documentFilename Document filename
     * @param string $returnFormat     Return format
     *
     * @throws InvalidArgumentException
     *
     * @return null|resource
     */
    public function convertDocument($documentFilename, $returnFormat)
    {
        $ret = null;

        StaticValidator::execute($documentFilename, 'DocumentExtension');
        StaticValidator::execute($documentFilename, 'FileExists');
        StaticValidator::execute($returnFormat    , 'ReturnFormat');

        $query = [
            'returnFormat' => $returnFormat,
        ];

        $documentFilename = realpath($documentFilename);

        $json = file_get_contents($documentFilename);
        $json = base64_encode($json);

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('POST', $this->uri('/document/convert'), $options);

        if ($response instanceof Response && 200 === $response->getStatusCode()) {
            $ret  = base64_decode($response->getBody());
        }

        return $ret;
    }

    /**
     * Merge data into a template and return an array of binary data.
     * Each record in the array is the binary data of one document
     *
     * @param array   $mergeData        Array of merge data
     * @param string  $returnFormat     Return format
     * @param string  $templateName     Template name
     * @param string  $templateFilename Template filename on local file system
     * @param boolean $append           Append flag
     * @param array   $mergeSettings    Array of merge settings
     *
     * @throws InvalidArgumentException
     *
     * @return null|string
     */
    public function mergeDocument($mergeData, $returnFormat, $templateName = null, $templateFilename = null,
                                    $append = null, $mergeSettings = [])
    {
        $ret = null;

        StaticValidator::execute($mergeData   , 'TypeArray');
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
            $template = file_get_contents($templateFilename);
            $template = base64_encode($template);
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
     * Perform find and replace in document and return binary data.
     *
     * @param array  $findAndReplaceData Array of find and replace data
     * @param string $returnFormat       Return format
     * @param string $templateName       Template name
     * @param string $templateFilename   Template filename on local file system
     * @param array  $mergeSettings      Array of merge settings
     *
     * @throws InvalidArgumentException
     *
     * @return null|string
     */
    public function findAndReplaceDocument($findAndReplaceData, $returnFormat, $templateName = null,
                                           $templateFilename = null, $mergeSettings = [])
    {
        $ret = null;

        StaticValidator::execute($findAndReplaceData, 'TypeArray');
        StaticValidator::execute($returnFormat      , 'ReturnFormat');

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
            $template = file_get_contents($templateFilename);
            $template = base64_encode($template);
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
            $ret  = base64_decode($response->getBody());
        }

        return $ret;
    }


    /**
     * DELETE methods
     * =================================================================================================================
     */

    /**
     * Delete a template in template storage
     *
     * @param string $templateName Template name
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function deleteTemplate($templateName)
    {
        $ret = false;

        StaticValidator::execute($templateName, 'TemplateName');

        $query = [
            'templateName' => $templateName,
        ];

        $options = [
            RequestOptions::QUERY => $query,
        ];

        $response = $this->request('DELETE', $this->uri('/templates/delete'), $options);

        if ($response instanceof Response && 204 === $response->getStatusCode()) {
            $ret = true;
        }

        return $ret;
    }
}