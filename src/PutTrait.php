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
use TxTextControl\ReportingCloud\Assert\Assert;
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
        $ret = '';

        $response = $this->request('PUT', $this->uri('/account/apikey'), []);

        if ($response instanceof Response && StatusCode::CREATED === $response->getStatusCode()) {
            $ret = (string) json_decode($response->getBody()->getContents());
            Assert::assertApiKey($ret);
        }

        return $ret;
    }
}
