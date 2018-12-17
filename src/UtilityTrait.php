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
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\Filter\Filter;

/**
 * Trait UtilityTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait UtilityTrait
{
    /**
     * Abstract Methods
     * -----------------------------------------------------------------------------------------------------------------
     */

    /**
     * Return the REST client of the backend web service
     *
     * @return \GuzzleHttp\Client
     */
    abstract public function getClient(): Client;

    /**
     * Return the test flag
     *
     * @return mixed
     */
    abstract public function getTest(): ?bool;

    /**
     * Get the version string of the backend web service
     *
     * @return string
     */
    abstract public function getVersion(): ?string;

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
     * @return \GuzzleHttp\Psr7\Response
     * @throws \TxTextControl\ReportingCloud\Exception\RuntimeException
     */
    protected function request(string $method, string $uri, array $options)
    {
        $client = $this->getClient();

        try {
            if ($this->getTest()) {
                $test = Filter::filterBooleanToString($this->getTest());
                $options[RequestOptions::QUERY]['test'] = $test;
            }
            $response = $client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            $message = (string) $e->getMessage();
            $code    = (int)    $e->getCode();
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
        return sprintf('/%s%s', $this->getVersion(), $uri);
    }
}
