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
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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

    // <editor-fold desc="Constants (tracked changes)">

    /**
     * InsertedText tracked change
     */
    public const TRACKED_CHANGE_INSERTED_TEXT = 4096;

    /**
     * DeletedText tracked change
     */
    public const TRACKED_CHANGE_DELETED_TEXT = 8192;

    // </editor-fold>

    // <editor-fold desc="Constants (highlight mode)">

    /**
     * Never highlight mode
     */
    public const HIGHLIGHT_MODE_NEVER     = 1;

    /**
     * Activated highlight mode
     */
    public const HIGHLIGHT_MODE_ACTIVATED = 2;

    /**
     * Always highlight mode
     */
    public const HIGHLIGHT_MODE_ALWAYS    = 3;

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
     * @var string
     */
    private string $apiKey;

    /**
     * Backend username
     *
     * @var string
     * @deprecated Use $this->apiKey instead
     */
    private string $username;

    /**
     * Backend password
     *
     * @var string
     * @deprecated Use $this->apiKey instead
     */
    private string $password;

    /**
     * Backend base URI
     *
     * @var string
     */
    private string $baseUri;

    /**
     * Debug flag of REST client
     *
     * @var bool
     */
    private bool $debug;

    /**
     * When true, API call does not count against quota
     * "TEST MODE" watermark is added to document
     *
     * @var bool
     */
    private bool $test;

    /**
     * Backend timeout in seconds
     *
     * @var int
     */
    private int $timeout;

    /**
     * Backend version string
     *
     * @var string
     */
    private string $version;

    /**
     * REST client to backend
     *
     * @var Client
     */
    private Client $client;

    // </editor-fold>

    // <editor-fold desc="Methods">

    /**
     * Return the API key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        if (!isset($this->apiKey)) {
            $this->apiKey = '';
        }

        return $this->apiKey;
    }

    /**
     * Set the API key
     *
     * @param string $apiKey
     *
     * @return self
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Return the username
     *
     * @return string
     * @deprecated Use $this->getApiKey(): string instead
     */
    public function getUsername(): string
    {
        if (!isset($this->username)) {
            $this->username = '';
        }

        return $this->username;
    }

    /**
     * Set the username
     *
     * @param string $username
     *
     * @return self
     * @deprecated Use $this->setApiKey(string $apiKey): self instead
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Return the password
     *
     * @return string
     * @deprecated Use $this->getApiKey() instead
     */
    public function getPassword(): string
    {
        if (!isset($this->password)) {
            $this->password = '';
        }

        return $this->password;
    }

    /**
     * Set the password
     *
     * @param string $password
     *
     * @return self
     * @deprecated Use $this->setApiKey(string $apiKey): self instead
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Return the base URI of the backend web service
     *
     * @return string
     */
    public function getBaseUri(): string
    {
        if (!isset($this->baseUri)) {
            $baseUri = ConsoleUtils::baseUri();
            if (0 === strlen($baseUri)) {
                $baseUri = self::DEFAULT_BASE_URI;
            }
            Assert::assertBaseUri($baseUri);
            $this->setBaseUri($baseUri);
        }

        return $this->baseUri;
    }

    /**
     * Set the base URI of the backend web service
     *
     * @param string $baseUri
     *
     * @return self
     */
    public function setBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Return the debug flag
     *
     * @return bool
     */
    public function getDebug(): bool
    {
        if (!isset($this->debug)) {
            $this->debug = self::DEFAULT_DEBUG;
        }

        return $this->debug;
    }

    /**
     * Set the debug flag
     *
     * @param bool $debug Debug flag
     *
     * @return self
     */
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Return the test flag
     *
     * @return bool
     */
    public function getTest(): bool
    {
        if (!isset($this->test)) {
            $this->test = self::DEFAULT_TEST;
        }

        return $this->test;
    }

    /**
     * Set the test flag
     *
     * @param bool $test
     *
     * @return self
     */
    public function setTest(bool $test): self
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get the timeout (in seconds) of the backend web service
     *
     * @return int
     */
    public function getTimeout(): int
    {
        if (!isset($this->timeout)) {
            $this->timeout = self::DEFAULT_TIMEOUT;
        }

        return $this->timeout;
    }

    /**
     * Set the timeout (in seconds) of the backend web service
     *
     * @param int $timeout
     *
     * @return self
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get the version string of the backend web service
     *
     * @return string
     */
    public function getVersion(): string
    {
        if (!isset($this->version)) {
            $this->version = self::DEFAULT_VERSION;
        }

        return $this->version;
    }

    /**
     * Set the version string of the backend web service
     *
     * @param string $version
     *
     * @return self
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
        if (!isset($this->client)) {

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
     * @return self
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;

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

        try {
            $test = $this->getTest();
            if ($test) {
                assert(is_array($options[RequestOptions::QUERY]));
                $options[RequestOptions::QUERY]['test'] = Filter::filterBooleanToString($test);
            }
            $response = $client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
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
        return sprintf('/%s%s', $this->getVersion(), $uri);
    }

    /**
     * Return Authorization Header, with either API key or username and password
     *
     * @return string
     * @throws InvalidArgumentException
     */
    private function getAuthorizationHeader(): string
    {
        $apiKey = $this->getApiKey();

        if (strlen($apiKey) > 0) {
            return sprintf('ReportingCloud-APIKey %s', $apiKey);
        }

        $username = $this->getUsername();
        $password = $this->getPassword();

        if (strlen($username) > 0 && strlen($password) > 0) {
            $value = sprintf('%s:%s', $username, $password);
            return sprintf('Basic %s', base64_encode($value));
        }

        $message = 'Either the API key, or username and password must be set for authorization';
        throw new InvalidArgumentException($message);
    }

    // </editor-fold>
}
