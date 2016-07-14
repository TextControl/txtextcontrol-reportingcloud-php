<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Exception\RuntimeException;

/**
 * Abstract ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
abstract class AbstractReportingCloud
{
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
    const DEFAULT_TIMEOUT = 120; // seconds

    /**
     * Default debug flag of REST client
     *
     * @const DEFAULT_DEBUG
     */
    const DEFAULT_DEBUG = false;

    /**
     * Backend username
     *
     * @var string
     */
    protected $username;

    /**
     * Backend password
     *
     * @var string
     */
    protected $password;

    /**
     * Backend base URI
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Backend version string
     *
     * @var string
     */
    protected $version;

    /**
     * Backend timeout in seconds
     *
     * @var integer
     */
    protected $timeout;

    /**
     * REST client to backend
     *
     * @var Client
     */
    protected $client;

    /**
     * Debug flag of REST client
     *
     * @var boolean
     */
    protected $debug;

    /**
     * AbstractReportingCloud constructor
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        if (array_key_exists('username', $options)) {
            $this->setUsername($options['username']);
        }

        if (array_key_exists('password', $options)) {
            $this->setPassword($options['password']);
        }

        if (array_key_exists('base_uri', $options)) {
            $this->setBaseUri($options['base_uri']);
        }

        if (array_key_exists('version', $options)) {
            $this->setVersion($options['version']);
        }

        if (array_key_exists('timeout', $options)) {
            $this->setTimeout($options['timeout']);
        }

        if (array_key_exists('debug', $options)) {
            $this->setDebug($options['debug']);
        }
    }

    /**
     * Return the REST client of the backend web service
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        if (null === $this->client) {

            $usernamePassword = sprintf('%s:%s'   , $this->getUsername(), $this->getPassword());
            $authorization    = sprintf('Basic %s', base64_encode($usernamePassword));

            $client = new Client([
                'base_uri'              => $this->getBaseUri(),
                RequestOptions::TIMEOUT => $this->getTimeout(),
                RequestOptions::DEBUG   => $this->getDebug(),
                RequestOptions::HEADERS => [
                    'Authorization' => $authorization,
                ],
            ]);

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
     * @return integer
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
     * @param integer $timeout Timeout
     *
     * @return ReportingCloud
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (integer) $timeout;

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
     * @param boolean $debug Debug flag
     *
     * @return ReportingCloud
     */
    public function setDebug($debug)
    {
        $this->debug = (boolean) $debug;

        return $this;
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
        $ret = null;

        $options['curl'][CURLOPT_SSLVERSION] = 6;

        $client = $this->getClient();

        try {

            $ret = $client->request($method, $uri, $options);

        } catch (\Exception $exception) {

            // \GuzzleHttp\Exception\ClientException
            // \GuzzleHttp\Exception\ServerException

            $message = (string)  $exception->getMessage();
            $code    = (integer) $exception->getCode();

            throw new RuntimeException($message, $code);
        }

        return $ret;
    }

}