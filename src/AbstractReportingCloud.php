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

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Abstract ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
abstract class AbstractReportingCloud
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
    public const DEFAULT_DATE_FORMAT = 'Y-m-d\TH:i:sP';

    /**
     * Default time zone of backend
     *
     * @const DEFAULT_TIME_ZONE
     */
    public const DEFAULT_TIME_ZONE = 'UTC';

    /**
     * Default base URI of backend
     *
     * @const DEFAULT_BASE_URI
     */
    protected const DEFAULT_BASE_URI = 'https://api.reporting.cloud';

    /**
     * Default version string of backend
     *
     * @const DEFAULT_VERSION
     */
    protected const DEFAULT_VERSION = 'v1';

    /**
     * Default timeout of backend in seconds
     *
     * @const DEFAULT_TIMEOUT
     */
    protected const DEFAULT_TIMEOUT = 120;

    /**
     * Default test flag of backend
     *
     * @const DEFAULT_TEST
     */
    protected const DEFAULT_TEST = false;

    /**
     * Default debug flag of REST client
     *
     * @const DEFAULT_DEBUG
     */
    protected const DEFAULT_DEBUG = false;

    /**
     * Constants (ReportingCloud values)
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Document divider - none
     */
    public const DOCUMENT_DIVIDER_NONE = 1;

    /**
     * Document divider - new paragraph
     */
    public const DOCUMENT_DIVIDER_NEW_PARAGRAPH = 2;

    /**
     * Document divider - new section
     */
    public const DOCUMENT_DIVIDER_NEW_SECTION = 3;

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
     * Set and Get Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Return the API key
     *
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * Set the API key
     *
     * @param string $apiKey
     *
     * @return AbstractReportingCloud
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Return the username
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the username
     *
     * @param string $username
     *
     * @return AbstractReportingCloud
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Return the password
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the password
     *
     * @param string $password
     *
     * @return AbstractReportingCloud
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Return the base URI of the backend web service
     *
     * @return string|null
     */
    public function getBaseUri(): ?string
    {
        if (null === $this->baseUri) {
            $this->setBaseUri(self::DEFAULT_BASE_URI);
        }

        return $this->baseUri;
    }

    /**
     * Set the base URI of the backend web service
     *
     * @param string $baseUri
     *
     * @return AbstractReportingCloud
     */
    public function setBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Get the timeout (in seconds) of the backend web service
     *
     * @return int|null
     */
    public function getTimeout(): ?int
    {
        if (null === $this->timeout) {
            $this->setTimeout(self::DEFAULT_TIMEOUT);
        }

        return $this->timeout;
    }

    /**
     * Set the timeout (in seconds) of the backend web service
     *
     * @param int $timeout
     *
     * @return AbstractReportingCloud
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Return the debug flag
     *
     * @return bool|null
     */
    public function getDebug(): ?bool
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
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Return the test flag
     *
     * @return bool|null
     */
    public function getTest(): ?bool
    {
        if (null === $this->test) {
            $this->setTest(self::DEFAULT_TEST);
        }

        return $this->test;
    }

    /**
     * Set the test flag
     *
     * @param bool $test
     *
     * @return AbstractReportingCloud
     */
    public function setTest(bool $test): self
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get the version string of the backend web service
     *
     * @return string|null
     */
    public function getVersion(): ?string
    {
        if (null === $this->version) {
            $this->version = self::DEFAULT_VERSION;
        }

        return $this->version;
    }

    /**
     * Set the version string of the backend web service
     *
     * @param string $version
     *
     * @return AbstractReportingCloud
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Return the REST client of the backend web service
     *
     * @return Client
     */
    public function getClient(): Client
    {
        if (!$this->client instanceof Client) {

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
     * @param Client $client
     *
     * @return AbstractReportingCloud
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
