<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/ReportingCloud.PHP for the canonical source repository
 * @license   https://github.com/TextControl/ReportingCloud.PHP/LICENSE.md New BSD License
 * @copyright © 2016 Text Control GmbH
 */
namespace TXTextControl\ReportingCloud;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;

use TXTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TXTextControl\ReportingCloud\PropertyMap;
use TXTextControl\ReportingCloud\Validator\ImageFormats  as ImageFormatsValidator;
use TXTextControl\ReportingCloud\Validator\Page          as PageValidator;
use TXTextControl\ReportingCloud\Validator\ReturnFormats as ReturnFormatsValidator;
use TXTextControl\ReportingCloud\Validator\TemplateName  as TemplateNameValidator;
use TXTextControl\ReportingCloud\Validator\Timestamp     as TimeStampValidator;
use TXTextControl\ReportingCloud\Validator\ZoomFactor    as ZoomFactorValidator;

/**
 * ReportingCloud
 *
 * @package TXTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloud extends AbstractReportingCloud
{

    /**
     * GET methods
     * =================================================================================================================
     */

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

        $templateNameValidator = new TemplateNameValidator();
        $zoomFactorValidator   = new ZoomFactorValidator();
        $pageValidator         = new PageValidator();
        $imageFormatsValidator = new ImageFormatsValidator();

        if (!$templateNameValidator->isValid($templateName)) {
            throw new InvalidArgumentException(
                sprintf("'templateName' must a template name without any path information - '%s' was passed",
                    $templateName)
            );
        }

        if (!$zoomFactorValidator->isValid($zoomFactor)) {
            throw new InvalidArgumentException(
                sprintf("'zoomFactor' must be in the range %d..%d - '%s' was passed",
                    $zoomFactorValidator->getMin(),
                    $zoomFactorValidator->getMax(),
                    $zoomFactor)
            );
        }

        if (!$pageValidator->isValid($fromPage)) {
            throw new InvalidArgumentException(
                sprintf("'fromPage' must be greater than %d - '%s' was passed",
                    $pageValidator->getMin(),
                    $fromPage)
            );
        }

        if (!$pageValidator->isValid($toPage)) {
            throw new InvalidArgumentException(
                sprintf("'toPage' must be greater than %d - '%s' was passed",
                    $pageValidator->getMin(),
                    $toPage)
            );
        }

        if (!$imageFormatsValidator->isValid($imageFormat)) {
            throw new InvalidArgumentException(
                sprintf("'imageFormat' must be one of '%s' - '%s' was passed",
                    implode(', ', $imageFormatsValidator->getHaystack()),
                    $imageFormat)
            );
        }

        $query = [
            'templateName' => $templateName,
            'zoomFactor'   => $zoomFactor,
            'fromPage'     => $fromPage,
            'toPage'       => $toPage,
            'imageFormat'  => $imageFormat,
        ];

        $records = $this->get('/templates/thumbnails', $query);

        if (is_array($records) && count($records) > 0) {
            $ret = [];
            foreach ($records as $index => $data) {
                $ret[$index] = base64_decode($data);
            }
        }

        return $ret;
    }

    /**
     * Return the number of templates in template storage
     *
     * @return integer|null
     */
    public function getTemplateCount()
    {
        return $this->get('/templates/count');
    }

    /**
     * Return an array properties for the templates in template storage
     *
     * @return array|null
     */
    public function getTemplateList()
    {
        $ret = null;

        $propertyMap = new PropertyMap\TemplateList();

        $records = $this->get('/templates/list');

        if (is_array($records) && count($records) > 0) {
            $ret = [];
            foreach ($records as $index => $record) {
                if (!isset($ret[$index])) {
                    $ret[$index] = [];
                }
                foreach ($propertyMap->getMap() as $property => $key) {
                    $value = null;
                    if (isset($record[$property]) && strlen($record[$property]) > 0) {
                        $value = $record[$property];
                        if ('modified' == $key) {
                            $value = strtotime($value);
                        }
                    }
                    $ret[$index][$key] = $value;
                }
            }
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
     * @return bool
     */
    public function getTemplatePageCount($templateName)
    {
        $templateNameValidator = new TemplateNameValidator();

        if (!$templateNameValidator->isValid($templateName)) {
            throw new InvalidArgumentException(
                sprintf("'templateName' must a template name without any path information - '%s' was passed",
                    $templateName)
            );
        }

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
        $templateNameValidator = new TemplateNameValidator();

        if (!$templateNameValidator->isValid($templateName)) {
            throw new InvalidArgumentException(
                sprintf("'templateName' must a template name without any path information - '%s' was passed",
                    $templateName)
            );
        }

        $query = [
            'templateName' => $templateName,
        ];

        return (boolean) $this->get('/templates/exists', $query);
    }

    /**
     * Return an array properties for the ReportingCloud account
     *
     * @return array|null
     */
    public function getAccountSettings()
    {
        $ret = null;

        $propertyMap = new PropertyMap\AccountSettings();

        $records = $this->get('/account/settings');

        if (is_array($records) && count($records) > 0) {
            $ret = [];
            foreach ($propertyMap->getMap() as $property => $key) {
                $value = null;
                if (isset($records[$property]) && strlen($records[$property]) > 0) {
                    $value = $records[$property];
                    if ('valid_until' == $key) {
                        $value = strtotime($value);
                    }
                }
                $ret[$key] = $value;
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

        $templateNameValidator = new TemplateNameValidator();

        if (!$templateNameValidator->isValid($templateName)) {
            throw new InvalidArgumentException(
                sprintf("'templateName' must a template name without any path information - '%s' was passed",
                    $templateName
                )
            );
        }

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

        if ($response instanceof Response) {
            if (200 === $response->getStatusCode()) {
                $body = (string) $response->getBody();
                $ret  = json_decode($body, true);
            }
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

        if (!is_readable($templateFilename)) {
            throw new InvalidArgumentException(
                sprintf("'templateFilename' %s cannot be read from the local file system",
                    $templateFilename
                )
            );
        }

        $templateFilename = realpath($templateFilename);
        $templateName     = basename($templateFilename);

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $query = [
            'templateName' => $templateName,
        ];

        $body = file_get_contents($templateFilename);
        $body = base64_encode($body);
        $body = json_encode($body);

        $options = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::QUERY   => $query,
            RequestOptions::BODY    => $body,
        ];

        $response = $this->request('POST', $this->uri('/templates/upload'), $options);

        if ($response instanceof Response) {
            if (201 === $response->getStatusCode()) {
                $ret = true;
            }
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

        $returnFormatsValidator = new ReturnFormatsValidator();

        if (!is_readable($documentFilename)) {
            throw new InvalidArgumentException(
                sprintf("'documentFilename' %s cannot be read from the local file system",
                    $documentFilename
                )
            );
        }

        $documentFilename = realpath($documentFilename);

        if (!$returnFormatsValidator->isValid($returnFormat)) {
            throw new InvalidArgumentException(
                sprintf("'returnFormat' must be one of '%s' - '%s' was passed",
                    implode(', ', $returnFormatsValidator->getHaystack()),
                    $returnFormat)
            );
        }

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $query = [
            'returnFormat' => $returnFormat,
        ];

        $body = file_get_contents($documentFilename);
        $body = base64_encode($body);
        $body = json_encode($body);

        $options = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::QUERY   => $query,
            RequestOptions::BODY    => $body,
        ];

        $response = $this->request('POST', $this->uri('/document/convert'), $options);

        if ($response instanceof Response) {
            if (200 === $response->getStatusCode()) {
                $body = (string) $response->getBody();
                $ret  = base64_decode($body);
            }
        }

        return $ret;
    }

    /**
     * Merge data into a template and return an array of binary data.
     * Each record in the array is the binary data of one document
     *
     * @param array   $mergeData         Array of merge data
     * @param string  $returnFormat      Return format
     * @param string  $templateName      Template name
     * @param string  $templateFilename  Template filename on local file system
     * @param boolean $append            Append flag
     * @param array   $mergeSettings     Array of merge settings
     *
     * @throws InvalidArgumentException
     *
     * @return null|string
     */
    public function mergeDocument($mergeData, $returnFormat, $templateName = null, $templateFilename = null, $append = null, $mergeSettings = null)
    {
        $ret = null;

        $returnFormatsValidator = new ReturnFormatsValidator();
        $templateNameValidator  = new TemplateNameValidator();
        $timestampValidator     = new TimestampValidator();

        if (!$returnFormatsValidator->isValid($returnFormat)) {
            throw new InvalidArgumentException(
                sprintf("'returnFormat' must be one of '%s' - '%s' was passed",
                    implode(', ', $returnFormatsValidator->getHaystack()),
                    $returnFormat)
            );
        }

        if (null !== $templateName) {
            if (!$templateNameValidator->isValid($templateName)) {
                throw new InvalidArgumentException(
                    sprintf("'templateName' must a template name without any path information - '%s' was passed",
                        $templateName)
                );
            }
        }

        if (null !== $templateFilename) {
            if (!is_readable($templateFilename)) {
                throw new InvalidArgumentException(
                    sprintf("'templateFilename' %s cannot be read from the local file system",
                        $templateFilename)
                );
            }
            $templateFilename = realpath($templateFilename);
        }

        if (null !== $append) {
            if (!is_bool($append)) {
                throw new InvalidArgumentException(
                    sprintf("'append' must a boolean value - '%s' was passed",
                        gettype($append))
                );
            }
            if (true === $append ) {
                $append = 'true';   // This boolean value MUST be passed as a string to prevent Guzzle converting the
            } else {                // query parameter to ?append=0 or ?append=1, which the backend does not recognize.
                $append = 'false';  // The backend only recognizes query parameter ?append=true and ?append=false.
            }
        }

        if (null !== $mergeSettings) {
            if (!is_array($mergeSettings)) {
                throw new InvalidArgumentException(
                    sprintf("'mergeSettings' must a boolean value - '%s' was passed",
                        gettype($append))
                );
            }
        }

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $query = [
            'returnFormat' => $returnFormat,
            'append'       => $append,
        ];

        if (null !== $templateName) {
            $query['templateName'] = $templateName;
        }

        $mergeSettingsRC = null;

        if (is_array($mergeSettings)) {

            $mergeSettingsRC = [];  // 'RC' - this array is passed to reporting.cloud

            $propertyMap = new PropertyMap\MergeSettings();

            foreach ($propertyMap->getMap() as $property => $key) {
                if (isset($mergeSettings[$key])) {
                    $value = $mergeSettings[$key];
                    if ('remove_' == substr($key, 0, 7)) {
                        if (!is_bool($value)) {
                            throw new InvalidArgumentException(
                                sprintf("'%s' must be a boolean value - '%s' was passed", $key, $value)
                            );
                        }
                    }
                    if ('_date' == substr($key, -5)) {
                        if (!$timestampValidator->isValid($value)) {
                            throw new InvalidArgumentException(
                                sprintf("'%s' must contain a valid unix timestamp - '%s' was passed", $key, $value)
                            );
                        }
                        $value = date('r', $value);
                    }
                    $mergeSettingsRC[$property] = $value;
                }
            }
        }
        
        unset($mergeSettings);

        $mergeBody = [
            'mergeData' => $mergeData,
        ];

        if (null !== $templateFilename) {
            $template = file_get_contents($templateFilename);
            $template = base64_encode($template);
            //$template = json_encode($template);
            $mergeBody['template'] = $template;
        }

        if (null !== $mergeSettingsRC) {
            $mergeBody['mergeSettings'] = $mergeSettingsRC;
        }

        $body = json_encode($mergeBody);

        $options = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::QUERY   => $query,
            RequestOptions::BODY    => $body,
        ];

        $response = $this->request('POST', $this->uri('/document/merge'), $options);

        if ($response instanceof Response) {
            if (200 === $response->getStatusCode()) {
                $body = (string) $response->getBody();
                $body = json_decode($body);
                if (is_array($body) && count($body) > 0) {
                    $ret = [];
                    foreach ($body as $record) {
                        array_push($ret, base64_decode($record));
                    }
                }
            }
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

        $templateNameValidator = new TemplateNameValidator();

        if (!$templateNameValidator->isValid($templateName)) {
            throw new InvalidArgumentException(
                sprintf("'templateName' must a template name without any path information - '%s' was passed",
                    $templateName)
            );
        }

        $query = [
            'templateName' => $templateName,
        ];

        $options = [
            RequestOptions::QUERY => $query,
        ];

        $response = $this->request('DELETE', $this->uri('/templates/delete'), $options);

        if ($response instanceof Response) {
            if (204 === $response->getStatusCode()) {
                $ret = true;
            }
        }

        return $ret;
    }

}