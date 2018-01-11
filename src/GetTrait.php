<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2018 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Filter\StaticFilter;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\AccountSettings as AccountSettingsPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\ApiKey as ApiKeyPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\IncorrectWord as IncorrectWordMap;
use TxTextControl\ReportingCloud\PropertyMap\TemplateInfo as TemplateInfoPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\TemplateList as TemplateListPropertyMap;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

trait GetTrait
{
    abstract protected function uri($uri);

    abstract protected function request($method, $uri, $options = []);

    abstract protected function buildPropertyMapArray(array $array, PropertyMap $propertyMap);

    /**
     * Return an associative array of API keys associated with the Reporting Cloud account
     *
     * @return array|null
     */
    public function getApiKeys()
    {
        $ret = null;

        $propertyMap = new ApiKeyPropertyMap();

        $records = $this->get('/account/apikeys');

        if (is_array($records) && count($records) > 0) {
            $ret = [];
            foreach ($records as $record) {
                if (isset($record['key'])) {
                    StaticValidator::execute($record['key'], 'ApiKey');
                }
                if (isset($record['active'])) {
                    StaticValidator::execute($record['active'], 'TypeBoolean');
                }
                $ret[] = $this->buildPropertyMapArray($record, $propertyMap);
            }
        }

        return $ret;
    }

    /**
     * Check a corpus of text for spelling errors.
     *
     * Return an array of misspelled words, if spelling errors are found in the corpus of text.
     *
     * Return null, if no misspelled words are found in the corpus of text.
     *
     * @param string $text     Corpus of text that should be spell checked
     * @param string $language Language of specified text
     *
     * @return array|null
     */
    public function proofingCheck($text, $language)
    {
        $ret = null;

        StaticValidator::execute($text, 'TypeString');
        StaticValidator::execute($language, 'Language');

        $propertyMap = new IncorrectWordMap();

        $query = [
            'text'     => $text,
            'language' => $language,
        ];

        $records = $this->get('/proofing/check', $query);

        if (is_array($records) && count($records) > 0) {
            $ret = $this->buildPropertyMapArray($records, $propertyMap);
        }

        return $ret;
    }

    /**
     * Return an array of available dictionaries on the Reporting Cloud service
     *
     * @return array|null
     */
    public function getAvailableDictionaries()
    {
        $ret = null;

        $dictionaries = $this->get('/proofing/availabledictionaries');

        if (is_array($dictionaries) && count($dictionaries) > 0) {
            $ret = array_map('trim', $dictionaries);
        }

        return $ret;
    }

    /**
     * Return an array of suggestions for a misspelled word.
     *
     * @param string $word     Word that should be spell checked
     * @param string $language Language of specified text
     * @param int    $max      Maximum number of suggestions to return
     *
     * @return array|null
     */
    public function getProofingSuggestions($word, $language, $max = 10)
    {
        $ret = null;

        StaticValidator::execute($word, 'TypeString');
        StaticValidator::execute($language, 'Language');
        StaticValidator::execute($max, 'TypeInteger');

        $query = [
            'word'     => $word,
            'language' => $language,
            'max'      => $max,
        ];

        $records = $this->get('/proofing/suggestions', $query);

        if (is_array($records) && count($records) > 0) {
            $ret = array_map('trim', $records);
        }

        return $ret;
    }

    /**
     * Return an array of merge blocks and merge fields in a template file in template storage.
     *
     * @param string $templateName Template name
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
     * @param string $templateName Template name
     * @param int    $zoomFactor   Zoom factor
     * @param int    $fromPage     From page
     * @param int    $toPage       To page
     * @param string $imageFormat  Image format
     *
     * @throws InvalidArgumentException
     *
     * @return array|null
     */
    public function getTemplateThumbnails($templateName, $zoomFactor, $fromPage, $toPage, $imageFormat)
    {
        $ret = null;

        StaticValidator::execute($templateName, 'TemplateName');
        StaticValidator::execute($zoomFactor, 'ZoomFactor');
        StaticValidator::execute($fromPage, 'Page');
        StaticValidator::execute($toPage, 'Page');
        StaticValidator::execute($imageFormat, 'ImageFormat');

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
     * @return int
     */
    public function getTemplateCount()
    {
        return (int) $this->get('/templates/count');
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
     * @return int
     */
    public function getTemplatePageCount($templateName)
    {
        StaticValidator::execute($templateName, 'TemplateName');

        $query = [
            'templateName' => $templateName,
        ];

        return (int) $this->get('/templates/pagecount', $query);
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

        return (bool) $this->get('/templates/exists', $query);
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
     * @return null
     * @throws \Zend\Filter\Exception\ExceptionInterface
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
            $ret = json_decode($response->getBody(), true);
        }

        return $ret;
    }
}
