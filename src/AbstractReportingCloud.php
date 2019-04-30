<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\Filter\Filter;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

/**
 * Abstract ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
abstract class AbstractReportingCloud
{
    // <editor-fold desc="Constants (default values)">

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
    public const DEFAULT_BASE_URI = 'https://api.reporting.cloud';

    /**
     * Default debug flag of REST client
     *
     * @const DEFAULT_DEBUG
     */
    protected const DEFAULT_DEBUG = false;

    /**
     * Default test flag of backend
     *
     * @const DEFAULT_TEST
     */
    protected const DEFAULT_TEST = false;

    /**
     * Default timeout of backend in seconds
     *
     * @const DEFAULT_TIMEOUT
     */
    protected const DEFAULT_TIMEOUT = 120;

    /**
     * Default version string of backend
     *
     * @const DEFAULT_VERSION
     */
    protected const DEFAULT_VERSION = 'v1';

    // </editor-fold>

    // <editor-fold desc="Constants (document dividers)">

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

    // </editor-fold>

    // <editor-fold desc="Constants (file formats)">

    /**
     * DOC file format
     */
    public const FILE_FORMAT_DOC = 'DOC';

    /**
     * DOCX file format
     */
    public const FILE_FORMAT_DOCX = 'DOCX';

    /**
     * HTML file format
     */
    public const FILE_FORMAT_HTML = 'HTML';

    /**
     * PDF file format
     */
    public const FILE_FORMAT_PDF = 'PDF';

    /**
     * PDF/A file format
     */
    public const FILE_FORMAT_PDFA = 'PDFA';

    /**
     * RTF file format
     */
    public const FILE_FORMAT_RTF = 'RTF';

    /**
     * TX (Text Control) file format
     */
    public const FILE_FORMAT_TX = 'TX';

    /**
     * Pure text file format
     */
    public const FILE_FORMAT_TXT = 'TXT';

    /**
     * Bitmap file format
     */
    public const FILE_FORMAT_BMP = 'BMP';

    /**
     * GIF file format
     */
    public const FILE_FORMAT_GIF = 'GIF';

    /**
     * JPEG file format
     */
    public const FILE_FORMAT_JPG = 'JPG';

    /**
     * PNG file format
     */
    public const FILE_FORMAT_PNG = 'PNG';

    /**
     * XLSX file format
     */
    public const FILE_FORMAT_XLSX = 'XLSX';

    // </editor-fold>

    // <editor-fold desc="Constants (file format collections)">

    /**
     * Image file formats
     */
    public const FILE_FORMATS_IMAGE
        = [
            self::FILE_FORMAT_BMP,
            self::FILE_FORMAT_GIF,
            self::FILE_FORMAT_JPG,
            self::FILE_FORMAT_PNG,
        ];

    /**
     * Template file formats
     */
    public const FILE_FORMATS_TEMPLATE
        = [
            self::FILE_FORMAT_DOC,
            self::FILE_FORMAT_DOCX,
            self::FILE_FORMAT_RTF,
            self::FILE_FORMAT_TX,
        ];

    /**
     * Document file formats
     */
    public const FILE_FORMATS_DOCUMENT
        = [
            self::FILE_FORMAT_DOC,
            self::FILE_FORMAT_DOCX,
            self::FILE_FORMAT_HTML,
            self::FILE_FORMAT_PDF,
            self::FILE_FORMAT_RTF,
            self::FILE_FORMAT_TX,
        ];

    /**
     * Return file formats
     */
    public const FILE_FORMATS_RETURN
        = [
            self::FILE_FORMAT_DOC,
            self::FILE_FORMAT_DOCX,
            self::FILE_FORMAT_HTML,
            self::FILE_FORMAT_PDF,
            self::FILE_FORMAT_PDFA,
            self::FILE_FORMAT_RTF,
            self::FILE_FORMAT_TX,
            self::FILE_FORMAT_TXT,
        ];

    // </editor-fold>

    // <editor-fold desc="Properties">

    /**
     * Backend API key
     *
     * @var string|null
     */
    private $apiKey;

    /**
     * Backend username
     *
     * @var string|null
     */
    private $username;

    /**
     * Backend password
     *
     * @var string|null
     */
    private $password;

    /**
     * Backend base URI
     *
     * @var string|null
     */
    private $baseUri;

    /**
     * Debug flag of REST client
     *
     * @var bool|null
     */
    private $debug;

    /**
     * When true, API call does not count against quota
     * "TEST MODE" watermark is added to document
     *
     * @var bool|null
     */
    private $test;

    /**
     * Backend timeout in seconds
     *
     * @var int|null
     */
    private $timeout;

    /**
     * Backend version string
     *
     * @var string|null
     */
    private $version;

    /**
     * REST client to backend
     *
     * @var Client|null
     */
    private $client;

    // </editor-fold>

    // <editor-fold desc="Methods">

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
     * Return the debug flag
     *
     * @return bool|null
     */
    public function getDebug(): ?bool
    {
        return $this->debug;
    }

    /**
     * Set the debug flag
     *
     * @param bool $debug Debug flag
     *
     * @return AbstractReportingCloud
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
     * Get the timeout (in seconds) of the backend web service
     *
     * @return int|null
     */
    public function getTimeout(): ?int
    {
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
     * Get the version string of the backend web service
     *
     * @return string|null
     */
    public function getVersion(): ?string
    {
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
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        if (!$this->client instanceof Client) {

            $headers = [
                'Authorization' => $this->getAuthorizationHeader(),
            ];

            $options = [
                'base_uri'              => $this->getBaseUri(),
                RequestOptions::TIMEOUT => $this->getTimeout(),
                RequestOptions::DEBUG   => $this->getDebug(),
                RequestOptions::HEADERS => $headers,
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

    /**
     * Assign default values to option properties
     *
     * @return ReportingCloud
     */
    protected function setDefaultOptions(): self
    {
        if (null === $this->getBaseUri()) {
            $baseUri = ConsoleUtils::baseUri() ?? self::DEFAULT_BASE_URI;
            Assert::assertBaseUri($baseUri);
            $this->setBaseUri($baseUri);
        }

        if (null === $this->getDebug()) {
            $this->setDebug(self::DEFAULT_DEBUG);
        }

        if (null === $this->getTest()) {
            $this->setTest(self::DEFAULT_TEST);
        }

        if (null === $this->getTimeout()) {
            $this->setTimeout(self::DEFAULT_TIMEOUT);
        }

        if (null === $this->getVersion()) {
            $this->setVersion(self::DEFAULT_VERSION);
        }

        return $this;
    }

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
    protected function request(string $method, string $uri, array $options): ResponseInterface
    {
        $client = $this->getClient();

        if (null === $client) {
            $message = 'No HTTP Client has been set.';
            throw new RuntimeException($message);
        }

        try {
            $test = (bool) $this->getTest();
            if ($test) {
                $options[RequestOptions::QUERY]['test'] = Filter::filterBooleanToString($test);
            }
            $response = $client->request($method, $uri, $options);
        } catch (TransferException $e) {
            $message = (string) $e->getMessage();
            $code    = (int) $e->getCode();
            throw new RuntimeException($message, $code);
        }

        return $response;
    }

    /**
     * Construct URI with version number
     *
     * @param string $uri URI
     *
     * @return string
     */
    protected function uri(string $uri): string
    {
        $version = (string) $this->getVersion();

        return sprintf('/%s%s', $version, $uri);
    }

    /**
     * Return Authorization Header, with either API key or username and password
     *
     * @return string
     * @throws InvalidArgumentException
     */
    private function getAuthorizationHeader(): string
    {
        $apiKey = (string) $this->getApiKey();

        if (!empty($apiKey)) {
            return sprintf('ReportingCloud-APIKey %s', $apiKey);
        }

        $username = (string) $this->getUsername();
        $password = (string) $this->getPassword();

        if (!empty($username) && !empty($password)) {
            $value = sprintf('%s:%s', $username, $password);
            return sprintf('Basic %s', base64_encode($value));
        }

        $message = 'Either the API key, or username and password must be set for authorization';
        throw new InvalidArgumentException($message);
    }

    // </editor-fold>
}
