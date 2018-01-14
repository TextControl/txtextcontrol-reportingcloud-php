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
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\PropertyMap\MergeSettings as MergeSettingsPropertyMap;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

trait UtilityTrait
{
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
     * Request the URI with options
     *
     * @param string $method  HTTP method
     * @param string $uri     URI
     * @param array  $options Options
     *
     * @return null|mixed|\Psr\Http\Message\ResponseInterface
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

    /**
     * Using the passed propertyMap, recursively build array
     *
     * @param array       $array       Array
     * @param PropertyMap $propertyMap PropertyMap
     *
     * @return array
     */
    protected function buildPropertyMapArray(array $array, PropertyMap $propertyMap)
    {
        $ret = [];

        foreach ($array as $key => $value) {
            $map = $propertyMap->getMap();
            if (isset($map[$key])) {
                $key = $map[$key];
            }
            if (is_array($value)) {
                $value = $this->buildPropertyMapArray($value, $propertyMap);
            }
            $ret[$key] = $value;
        }

        return $ret;
    }

    /**
     * Using passed mergeSettings array, build array for backend
     *
     * @param array $array MergeSettings array
     *
     * @return array
     */
    protected function buildMergeSettingsArray(array $array)
    {
        $ret = [];

        $propertyMap = new MergeSettingsPropertyMap();

        foreach ($propertyMap->getMap() as $property => $key) {
            if (isset($array[$key])) {
                $value = $array[$key];
                if ('culture' == $key) {
                    StaticValidator::execute($value, 'Culture');
                }
                if ('remove_' == substr($key, 0, 7)) {
                    StaticValidator::execute($value, 'TypeBoolean');
                }
                if ('_date' == substr($key, -5)) {
                    StaticValidator::execute($value, 'Timestamp');
                    $value = StaticFilter::execute($value, 'TimestampToDateTime');
                }
                $ret[$property] = $value;
            }
        }

        return $ret;
    }

    /**
     * Using passed findAndReplaceData associative array (key-value), build array for backend (list of string arrays)
     *
     * @param array $array FindAndReplaceData array
     *
     * @return array
     */
    protected function buildFindAndReplaceDataArray(array $array)
    {
        $ret = [];

        foreach ($array as $search => $replace) {
            array_push($ret, [
                $search,
                $replace,
            ]);
        }

        return $ret;
    }
}
