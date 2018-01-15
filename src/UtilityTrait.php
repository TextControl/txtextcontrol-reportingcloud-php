<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2018 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud;

use GuzzleHttp\RequestOptions;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\Filter\StaticFilter;

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
    abstract public function getClient();

    /**
     * Return the test flag
     *
     * @return mixed
     */
    abstract public function getTest();

    /**
     * Get the version string of the backend web service
     *
     * @return string
     */
    abstract public function getVersion();

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
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     *
     * @throws RuntimeException
     */
    protected function request($method, $uri, $options)
    {
        $client = $this->getClient();

        try {
            if ($this->getTest()) {
                $options[RequestOptions::QUERY]['test'] = StaticFilter::execute($this->getTest(), 'BooleanToString');
            }
            $ret = $client->request($method, $uri, $options);
        } catch (\Exception $exception) {
            // \GuzzleHttp\Exception\ClientException
            // \GuzzleHttp\Exception\ServerException
            $message = (string) $exception->getMessage();
            $code    = (int) $exception->getCode();
            throw new RuntimeException($message, $code);
        }

        return $ret;
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
}
