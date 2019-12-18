<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://github.com/TextControl/txtextcontrol-reportingcloud-php/blob/master/LICENSE.md
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud;

use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\StatusCode\StatusCode;

/**
 * Trait DeleteTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait DeleteTrait
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

    // </editor-fold>

    // <editor-fold desc="Methods">

    /**
     * Delete an API key
     *
     * @param string $key
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteApiKey(string $key): bool
    {
        Assert::assertApiKey($key);

        $query = [
            'key' => $key,
        ];

        return $this->delete('/account/apikey', $query, null, StatusCode::OK);
    }

    /**
     * Delete a template in template storage
     *
     * @param string $templateName
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteTemplate(string $templateName): bool
    {
        Assert::assertTemplateName($templateName);

        $query = [
            'templateName' => $templateName,
        ];

        return $this->delete('/templates/delete', $query, null, StatusCode::NO_CONTENT);
    }

    /**
     * Execute a DELETE request via REST client
     *
     * @param string     $uri        URI
     * @param array|null $query      Query
     * @param mixed|null $json       JSON
     * @param int|null   $statusCode Required HTTP status code for response
     *
     * @return bool
     */
    private function delete(
        string $uri,
        ?array $query = null,
        $json = null,
        ?int $statusCode = null
    ): bool {
        $ret = false;

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON  => $json,
        ];

        $response = $this->request('DELETE', $this->uri($uri), $options);

        if ($statusCode === $response->getStatusCode()) {
            $ret = true;
        }

        return $ret;
    }

    // </editor-fold>
}
