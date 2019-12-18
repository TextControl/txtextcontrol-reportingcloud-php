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

namespace TxTextControl\ReportingCloud\StatusCode;

/**
 * Abstract AbstractStatusCode
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
abstract class AbstractStatusCode
{
    /**
     * The HTTP 200 OK success status response code indicates that the request has succeeded.
     *
     * @see: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200
     */
    public const OK = 200;

    /**
     * The HTTP 201 Created success status response code indicates that the request has succeeded and has led to the
     * creation of a resource.
     *
     * @see: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/201
     */
    public const CREATED = 201;

    /**
     * The HTTP 204 No Content success status response code indicates that the request has succeeded, but that the
     * client doesn't need to go away from its current page.
     *
     * @see: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/204
     */
    public const NO_CONTENT = 204;
}
