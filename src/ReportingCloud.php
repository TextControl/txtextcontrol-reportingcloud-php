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

/**
 * ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloud
{
    use DeleteTrait;
    use GetTrait;
    use PostTrait;
    use PutTrait;
    use SetGetTrait;
    use UtilityTrait;

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
    const DEFAULT_DATE_FORMAT = 'Y-m-d\TH:i:sP';

    /**
     * Default time zone of backend
     *
     * @const DEFAULT_TIME_ZONE
     */
    const DEFAULT_TIME_ZONE = 'UTC';

    /**
     * Default base URI of backend
     *
     * @const DEFAULT_BASE_URI
     */
    const DEFAULT_BASE_URI = 'https://api.reporting.cloud';

    /**
     * Default version string of backend
     *
     * @const DEFAULT_VERSION
     */
    const DEFAULT_VERSION = 'v1';

    /**
     * Default timeout of backend in seconds
     *
     * @const DEFAULT_TIMEOUT
     */
    const DEFAULT_TIMEOUT = 120;

    /**
     * Default test flag of backend
     *
     * @const DEFAULT_TEST
     */
    const DEFAULT_TEST = false;

    /**
     * Default debug flag of REST client
     *
     * @const DEFAULT_DEBUG
     */
    const DEFAULT_DEBUG = false;

    /**
     * AbstractReportingCloud constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $methods = [
            'api_key'  => 'setApiKey',
            'base_uri' => 'setBaseUri',
            'debug'    => 'setDebug',
            'password' => 'setPassword',
            'test'     => 'setTest',
            'timeout'  => 'setTimeout',
            'username' => 'setUsername',
            'version'  => 'setVersion',
        ];

        foreach ($methods as $key => $method) {
            if (array_key_exists($key, $options)) {
                $this->$method($options[$key]);
            }
        }
    }
}
