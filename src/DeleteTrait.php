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

use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\StatusCode\StatusCode;

/**
 * Trait DeleteTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait DeleteTrait
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
     * DELETE Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Delete an API key
     *
     * @param string $key
     *
     * @return bool
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function deleteApiKey(string $key): bool
    {
        Assert::assertApiKey($key);

        $query = [
            'key' => $key,
        ];

        return $this->delete('/account/apikey', $query, '', StatusCode::OK);
    }

    /**
     * Delete a template in template storage
     *
     * @param string $templateName
     *
     * @return bool
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public function deleteTemplate(string $templateName): bool
    {
        Assert::assertTemplateName($templateName);

        $query = [
            'templateName' => $templateName,
        ];

        return $this->delete('/templates/delete', $query, '', StatusCode::NO_CONTENT);
    }

    /**
     * Execute a DELETE request via REST client
     *
     * @param string       $uri                URI
     * @param array        $query              Query
     * @param string|array $json               JSON
     * @param int          $responseStatusCode Required HTTP status code for response
     *
     * @return bool
     */
    private function delete(string $uri, array $query = [], $json = '', int $responseStatusCode = 0)
    {
        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('DELETE', $this->uri($uri), $options);

        return ($responseStatusCode === $response->getStatusCode()) ? true : false;
    }
}
