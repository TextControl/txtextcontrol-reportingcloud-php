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

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\Filter\StaticFilter;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\AccountSettings as AccountSettingsPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\ApiKey as ApiKeyPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\IncorrectWord as IncorrectWordMap;
use TxTextControl\ReportingCloud\PropertyMap\MergeSettings as MergeSettingsPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\TemplateInfo as TemplateInfoPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\TemplateList as TemplateListPropertyMap;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

/**
 * ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloud
{
    /**
     * Constants
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Default date/time format of backend is 'ISO 8601'
     *
     * Note, last letter is 'P' and not 'O':
     *
     * O - Difference to Greenwich time (GMT) in hours (e.g. +0200)
     * P - Difference to Greenwich time (GMT) with colon between hours and minutes (e.g. +02:00)
     *
     * Backend uses the 'P' variant
     *
     * @const DEFAULT_DATE_FORMAT
     */
    const DEFAULT_DATE_FORMAT = 'Y-m-d\TH:i:sP';

    /**
     * Default time zone of backend
     *
     * @const DEFAULT_TIME_ZONE
     */
    const DEFAULT_TIME_ZONE = 'UTC';

    /**
     * Default base URI of backend
     *
     * @const DEFAULT_BASE_URI
     */
    const DEFAULT_BASE_URI = 'https://api.reporting.cloud';

    /**
     * Default version string of backend
     *
     * @const DEFAULT_VERSION
     */
    const DEFAULT_VERSION = 'v1';

    /**
     * Default timeout of backend in seconds
     *
     * @const DEFAULT_TIMEOUT
     */
    const DEFAULT_TIMEOUT = 120;

    /**
     * Default test flag of backend
     *
     * @const DEFAULT_TEST
     */
    const DEFAULT_TEST = false;

    /**
     * Default debug flag of REST client
     *
     * @const DEFAULT_DEBUG
     */
    const DEFAULT_DEBUG = false;

    /**
     * Properties
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Backend API key
     *
     * @var string|null
     */
    protected $apiKey;

    /**
     * Backend username
     *
     * @var string|null
     */
    protected $username;

    /**
     * Backend password
     *
     * @var string|null
     */
    protected $password;

    /**
     * When true, API call does not count against quota
     * "TEST MODE" watermark is added to document
     *
     * @var bool|null
     */
    protected $test;

    /**
     * Backend base URI
     *
     * @var string|null
     */
    protected $baseUri;

    /**
     * Backend version string
     *
     * @var string|null
     */
    protected $version;

    /**
     * Backend timeout in seconds
     *
     * @var int|null
     */
    protected $timeout;

    /**
     * REST client to backend
     *
     * @var Client|null
     */
    protected $client;

    /**
     * Debug flag of REST client
     *
     * @var bool|null
     */
    protected $debug;

    /**
     * Constructor Method
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * ReportingCloud constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $methods = [
            'api_key'  => 'setApiKey',
            'base_uri' => 'setBaseUri',
            'debug'    => 'setDebug',
            'password' => 'setPassword',
            'test'     => 'setTest',
            'timeout'  => 'setTimeout',
            'username' => 'setUsername',
            'version'  => 'setVersion',
        ];

        foreach ($methods as $key => $method) {
            if (array_key_exists($key, $options)) {
                $this->$method($options[$key]);
            }
        }
    }

    /**
     * Set and Get Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Return the API key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set the API key
     *
     * @param string $apiKey API key
     *
     * @return ReportingCloud
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Return the username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the username
     *
     * @param string $username Username
     *
     * @return ReportingCloud
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Return the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the password
     *
     * @param string $password Password
     *
     * @return ReportingCloud
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Return the base URI of the backend web service
     *
     * @return string
     */
    public function getBaseUri()
    {
        if (null === $this->baseUri) {
            $this->setBaseUri(self::DEFAULT_BASE_URI);
        }

        return $this->baseUri;
    }

    /**
     * Set the base URI of the backend web service
     *
     * @param string $baseUri Base URI
     *
     * @return ReportingCloud
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Get the timeout (in seconds) of the backend web service
     *
     * @return int
     */
    public function getTimeout()
    {
        if (null === $this->timeout) {
            $this->setTimeout(self::DEFAULT_TIMEOUT);
        }

        return $this->timeout;
    }

    /**
     * Set the timeout (in seconds) of the backend web service
     *
     * @param int $timeout Timeout
     *
     * @return ReportingCloud
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int) $timeout;

        return $this;
    }

    /**
     * Return the debug flag
     *
     * @return mixed
     */
    public function getDebug()
    {
        if (null === $this->debug) {
            $this->setDebug(self::DEFAULT_DEBUG);
        }

        return $this->debug;
    }

    /**
     * Set the debug flag
     *
     * @param bool $debug Debug flag
     *
     * @return ReportingCloud
     */
    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;

        return $this;
    }

    /**
     * Return the test flag
     *
     * @return mixed
     */
    public function getTest()
    {
        if (null === $this->test) {
            $this->setTest(self::DEFAULT_TEST);
        }

        return $this->test;
    }

    /**
     * Set the test flag
     *
     * @param bool $test Test flag
     *
     * @return ReportingCloud
     */
    public function setTest($test)
    {
        $this->test = (bool) $test;

        return $this;
    }

    /**
     * Get the version string of the backend web service
     *
     * @return string
     */
    public function getVersion()
    {
        if (null === $this->version) {
            $this->version = self::DEFAULT_VERSION;
        }

        return $this->version;
    }

    /**
     * Set the version string of the backend web service
     *
     * @param string $version Version string
     *
     * @return ReportingCloud
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

     /**
     * Return the REST client of the backend web service
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        if (null === $this->client) {

            $authorization = function () {

                if (!empty($this->getApiKey())) {
                    return sprintf('ReportingCloud-APIKey %s', $this->getApiKey());
                }

                if (!empty($this->getUsername()) && !empty($this->getPassword())) {
                    $value = sprintf('%s:%s', $this->getUsername(), $this->getPassword());
                    return sprintf('Basic %s', base64_encode($value));
                }

                $message = 'Either the API key, or username and password must be set for authorization';
                throw new InvalidArgumentException($message);
            };

            $options = [
                'base_uri'              => $this->getBaseUri(),
                RequestOptions::TIMEOUT => $this->getTimeout(),
                RequestOptions::DEBUG   => $this->getDebug(),
                RequestOptions::HEADERS => [
                    'Authorization' => $authorization(),
                ],
            ];

            $client = new Client($options);

            $this->setClient($client);
        }

        return $this->client;
    }

    /**
     * Set the REST client of the backend web service
     *
     * @param Client $client REST client
     *
     * @return ReportingCloud
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Utility Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

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
    protected function request($method, $uri, $options)
    {
        $client = $this->getClient();

        try {
            if ($this->getTest()) {
                $options[RequestOptions::QUERY]['test'] = StaticFilter::execute($this->getTest(), 'BooleanToString');
            }
            $ret = $client->request($method, $uri, $options);
        } catch (\Exception $exception) {
            // \GuzzleHttp\Exception\ClientException
            // \GuzzleHttp\Exception\ServerException
            $message = (string) $exception->getMessage();
            $code    = (int) $exception->getCode();
            throw new RuntimeException($message, $code);
        }

        return $ret;
    }

    /**
     * Construct URI with version number
     *
     * @param string $uri URI
     *
     * @return string
     */
    protected function uri($uri)
    {
        return sprintf('/%s%s', $this->getVersion(), $uri);
    }

    /**
     * Using the passed propertyMap, recursively build array
     *
     * @param array       $array       Array
     * @param PropertyMap $propertyMap PropertyMap
     *
     * @return array
     */
    protected function buildPropertyMapArray(array $array, PropertyMap $propertyMap)
    {
        $ret = [];

        foreach ($array as $key => $value) {
            $map = $propertyMap->getMap();
            if (isset($map[$key])) {
                $key = $map[$key];
            }
            if (is_array($value)) {
                $value = $this->buildPropertyMapArray($value, $propertyMap);
            }
            $ret[$key] = $value;
        }

        return $ret;
    }

    /**
     * Using passed mergeSettings array, build array for backend
     *
     * @param array $array MergeSettings array
     *
     * @return array
     */
    protected function buildMergeSettingsArray(array $array)
    {
        $ret = [];

        $propertyMap = new MergeSettingsPropertyMap();

        foreach ($propertyMap->getMap() as $property => $key) {
            if (isset($array[$key])) {
                $value = $array[$key];
                if ('culture' == $key) {
                    StaticValidator::execute($value, 'Culture');
                }
                if ('remove_' == substr($key, 0, 7)) {
                    StaticValidator::execute($value, 'TypeBoolean');
                }
                if ('_date' == substr($key, -5)) {
                    StaticValidator::execute($value, 'Timestamp');
                    $value = StaticFilter::execute($value, 'TimestampToDateTime');
                }
                $ret[$property] = $value;
            }
        }

        return $ret;
    }

    /**
     * Using passed findAndReplaceData associative array (key-value), build array for backend (list of string arrays)
     *
     * @param array $array FindAndReplaceData array
     *
     * @return array
     */
    protected function buildFindAndReplaceDataArray(array $array)
    {
        $ret = [];

        foreach ($array as $key => $value) {
            array_push($ret, [
                $key,
                $value,
            ]);
        }

        return $ret;
    }

    /**
     * DELETE Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Delete an API key
     *
     * @param string $key API key
     *
     * @return bool
     */
    public function deleteApiKey($key)
    {
        $ret = false;

        StaticValidator::execute($key, 'ApiKey');

        $options = [
            RequestOptions::QUERY => [
                'key' => $key,
            ],
        ];

        $response = $this->request('DELETE', $this->uri('/account/apikey'), $options);

        if ($response instanceof Response && 200 === $response->getStatusCode()) {
            $ret = true;
        }

        return $ret;
    }

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

        $options = [
            RequestOptions::QUERY => [
                'templateName' => $templateName,
            ],
        ];

        $response = $this->request('DELETE', $this->uri('/templates/delete'), $options);

        if ($response instanceof Response && 204 === $response->getStatusCode()) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * GET Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

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
     * @throws \Zend\Filter\Exception\ExceptionInterface
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
     * @return string|null
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

    /**
     * POST Methods
     * -----------------------------------------------------------------------------------------------------------------
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
     * @return string|null
     */
    public function convertDocument($documentFilename, $returnFormat)
    {
        $ret = null;

        StaticValidator::execute($documentFilename, 'DocumentExtension');
        StaticValidator::execute($documentFilename, 'FileExists');
        StaticValidator::execute($returnFormat, 'ReturnFormat');

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
     * @throws InvalidArgumentException
     *
     * @return array|null
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
     * @return string|null
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

    /**
     * PUT Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Create an API key
     *
     * @return string|null
     */
    public function createApiKey()
    {
        $ret = null;

        $response = $this->request('PUT', $this->uri('/account/apikey'), []);

        if ($response instanceof Response && 201 === $response->getStatusCode()) {
            $ret = (string) json_decode($response->getBody(), true);
            StaticValidator::execute($ret, 'ApiKey');
        }

        return $ret;
    }
}
