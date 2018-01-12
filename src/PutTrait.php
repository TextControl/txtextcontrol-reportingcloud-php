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

use GuzzleHttp\Psr7\Response;
use TxTextControl\ReportingCloud\PropertyMap\AbstractPropertyMap as PropertyMap;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

trait PutTrait
{
    abstract protected function uri($uri);

    abstract protected function request($method, $uri, $options);

    abstract protected function buildPropertyMapArray(array $array, PropertyMap $propertyMap);

    /**
     * Create an API key
     *
     * @return null|string
     */
    public function createApiKey()
    {
        $ret = null;

        $response = $this->request('PUT', $this->uri('/account/apikey'), []);

        if ($response instanceof Response && 201 === $response->getStatusCode()) {
            $ret = (string) json_decode($response->getBody(), true);
            StaticValidator::execute($ret, 'ApiKey');
        }

        return $ret;
    }
}