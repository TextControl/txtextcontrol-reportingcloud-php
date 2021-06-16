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

use Ctw\Http\HttpStatus;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\Filter\Filter;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\AccountSettings as AccountSettingsPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\ApiKey as ApiKeyPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\IncorrectWord as IncorrectWordMap;
use TxTextControl\ReportingCloud\PropertyMap\TemplateInfo as TemplateInfoPropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\TemplateList as TemplateListPropertyMap;

/**
 * Trait GetTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait GetTrait
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
     * Return an associative array of API keys associated with the Reporting Cloud account
     *
     * @return array<int, array<int|string, array|bool|int|string>>
     */
    public function getApiKeys(): array
    {
        $ret = [];

        $propertyMap = new ApiKeyPropertyMap();

        $result = $this->get('/account/apikeys', [], '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            foreach ($result as $record) {
                if (!is_array($record)) {
                    continue;
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
     * Return an empty array, if no misspelled words are found in the corpus of text.
     *
     * @param string $text     Corpus of text that should be spell checked
     * @param string $language Language of specified text
     *
     * @return array<int|string, array|bool|int|string>
     * @throws InvalidArgumentException
     */
    public function proofingCheck(string $text, string $language): array
    {
        $ret = [];

        Assert::assertLanguage($language);

        $propertyMap = new IncorrectWordMap();

        $query = [
            'text'     => $text,
            'language' => $language,
        ];

        $result = $this->get('/proofing/check', $query, '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = $this->buildPropertyMapArray($result, $propertyMap);
        }

        return $ret;
    }

    /**
     * Return an array of available dictionaries on the Reporting Cloud service
     *
     * @return array<int, string>
     */
    public function getAvailableDictionaries(): array
    {
        $ret = [];

        $result = $this->get('/proofing/availabledictionaries', [], '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = array_map('trim', $result);
        }

        return $ret;
    }

    /**
     * Return an array of suggestions for a misspelled word
     *
     * @param string $word     Word that should be spell checked
     * @param string $language Language of specified text
     * @param int    $max      Maximum number of suggestions to return
     *
     * @return array<int, string>
     * @throws InvalidArgumentException
     */
    public function getProofingSuggestions(string $word, string $language, int $max = 10): array
    {
        $ret = [];

        Assert::assertLanguage($language);

        $query = [
            'word'     => $word,
            'language' => $language,
            'max'      => $max,
        ];

        $result = $this->get('/proofing/suggestions', $query, '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = array_map('trim', $result);
        }

        return $ret;
    }

    /**
     * Return an array of merge blocks and merge fields in a template file in template storage
     *
     * @param string $templateName Template name
     *
     * @return array<int|string, array|bool|int|string>
     * @throws InvalidArgumentException
     */
    public function getTemplateInfo(string $templateName): array
    {
        $ret = [];

        $propertyMap = new TemplateInfoPropertyMap();

        Assert::assertTemplateName($templateName);

        $query = [
            'templateName' => $templateName,
        ];

        $result = $this->get('/templates/info', $query, '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = $this->buildPropertyMapArray($result, $propertyMap);
        }

        return $ret;
    }

    /**
     * Generate a thumbnail image per page of specified template in template storage.
     * Return an array of binary data with each record containing one thumbnail.
     *
     * @param string $templateName Template name
     * @param int    $zoomFactor   Zoom factor
     * @param int    $fromPage     From page
     * @param int    $toPage       To page
     * @param string $imageFormat  Image format
     *
     * @throws InvalidArgumentException
     * @return array<int, string>
     */
    public function getTemplateThumbnails(
        string $templateName,
        int $zoomFactor,
        int $fromPage,
        int $toPage,
        string $imageFormat
    ): array {

        Assert::assertTemplateName($templateName);
        Assert::assertZoomFactor($zoomFactor);
        Assert::assertPage($fromPage);
        Assert::assertPage($toPage);
        Assert::assertImageFormat($imageFormat);

        $query = [
            'templateName' => $templateName,
            'zoomFactor'   => $zoomFactor,
            'fromPage'     => $fromPage,
            'toPage'       => $toPage,
            'imageFormat'  => $imageFormat,
        ];

        $result = $this->get('/templates/thumbnails', $query, '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            foreach ($result as $key => $value) {
                $value = base64_decode($value, true);
                assert(is_string($value));
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Return the number of templates in template storage
     *
     * @return int
     */
    public function getTemplateCount(): int
    {
        return (int) $this->get('/templates/count', [], '', HttpStatus::STATUS_OK);
    }

    /**
     * Return an array properties for the templates in template storage
     *
     * @return array<int|string, array|bool|int|string>
     */
    public function getTemplateList(): array
    {
        $ret = [];

        $propertyMap = new TemplateListPropertyMap();

        $result = $this->get('/templates/list', [], '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = $this->buildPropertyMapArray($result, $propertyMap);
            array_walk($ret, function (array &$record): void {
                $key = 'modified';
                if (isset($record[$key])) {
                    Assert::assertDateTime($record[$key]);
                    $record[$key] = Filter::filterDateTimeToTimestamp($record[$key]);
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
     * @return int
     * @throws InvalidArgumentException
     */
    public function getTemplatePageCount(string $templateName): int
    {
        Assert::assertTemplateName($templateName);

        $query = [
            'templateName' => $templateName,
        ];

        return (int) $this->get('/templates/pagecount', $query, '', HttpStatus::STATUS_OK);
    }

    /**
     * Return true, if the template exists in template storage
     *
     * @param string $templateName Template name
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function templateExists(string $templateName): bool
    {
        Assert::assertTemplateName($templateName);

        $query = [
            'templateName' => $templateName,
        ];

        return (bool) $this->get('/templates/exists', $query, '', HttpStatus::STATUS_OK);
    }

    /**
     * Return an array of available fonts on the Reporting Cloud service
     *
     * @return array<int, string>
     */
    public function getFontList(): array
    {
        $ret = [];

        $result = $this->get('/fonts/list', [], '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = array_map('trim', $result);
        }

        return $ret;
    }

    /**
     * Return an array properties for the ReportingCloud account
     *
     * @return array<int|string, array|bool|int|string>
     * @throws InvalidArgumentException
     */
    public function getAccountSettings(): array
    {
        $ret = [];

        $propertyMap = new AccountSettingsPropertyMap();

        $result = $this->get('/account/settings', [], '', HttpStatus::STATUS_OK);

        if (is_array($result)) {
            $ret = $this->buildPropertyMapArray($result, $propertyMap);
            $key = 'valid_until';
            if (isset($ret[$key]) && is_string($ret[$key])) {
                Assert::assertDateTime($ret[$key]);
                $ret[$key] = Filter::filterDateTimeToTimestamp($ret[$key]);
            }
        }

        return $ret;
    }

    /**
     * Download the binary data of a template from template storage
     *
     * @param string $templateName Template name
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function downloadTemplate(string $templateName): string
    {
        Assert::assertTemplateName($templateName);

        $query = [
            'templateName' => $templateName,
        ];

        $result = (string) $this->get('/templates/download', $query, '', HttpStatus::STATUS_OK);

        if (strlen($result) > 0) {
            $decoded = base64_decode($result, true);
            if (is_string($decoded)) {
                $result = $decoded;
            }
        }

        return $result;
    }

    /**
     * Execute a GET request via REST client
     *
     * @param string                    $uri        URI
     * @param array<string, int|string> $query      Query
     * @param mixed                     $json       JSON
     * @param int                       $statusCode Required HTTP status code for response
     *
     * @return mixed
     */
    private function get(
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

        $response = $this->request('GET', $this->uri($uri), $options);

        if ($statusCode === $response->getStatusCode()) {
            $ret = json_decode($response->getBody()->getContents(), true);
        }

        return $ret;
    }

    // </editor-fold>
}
