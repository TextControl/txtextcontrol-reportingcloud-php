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

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\StatusCode\StatusCode;

/**
 * Trait PutTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait PutTrait
{
    /**
     * Abstract Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

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
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     *
     * @throws RuntimeException
     */
    abstract protected function request(string $method, string $uri, array $options);

    /**
     * Using the passed propertyMap, recursively build array
     *
     * @param array       $array       Array
     * @param PropertyMap $propertyMap PropertyMap
     *
     * @return array
     */
    abstract protected function buildPropertyMapArray(array $array, PropertyMap $propertyMap): array;

    /**
     * PUT Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Create an API key
     *
     * @return string
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function createApiKey(): string
    {
        return $this->put('/account/apikey');
    }

    /**
     * Execute a PUT request via REST client
     *
     * @param string $uri   URI
     * @param array  $query Query
     *
     * @return string
     */
    private function put(string $uri, array $query = [])
    {
        $options = [
            RequestOptions::QUERY => $query,
        ];

        $statusCodes = [
            StatusCode::CREATED,
        ];

        $response = $this->request('PUT', $this->uri($uri), $options);

        if (!$response instanceof Response) {
            return '';
        }

        if (!in_array($response->getStatusCode(), $statusCodes)) {
            return '';
        }

        return (string) json_decode($response->getBody()->getContents());
    }
}
