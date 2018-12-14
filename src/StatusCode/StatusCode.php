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

namespace TxTextControl\ReportingCloud\StatusCode;

/**
 * Class StatusCode
 *
 * A set of constants representing the HTTP status codes returned by ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 */
class StatusCode
{
    /**
     * @see: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200
     */
    public const OK = 200;

    /**
     * @see: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/201
     */
    public const CREATED = 201;

    /**
     * @see: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/204
     */
    public const NO_CONTENT = 204;
}
