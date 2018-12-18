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

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertBase64DataTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertBase64DataTrait
{
    /**
     * Validate base64 data
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public static function assertBase64Data(string $value, string $message = '')
    {
        if (!base64_decode($value, true)) {
            $format  = '%s must be base64 encoded';
            $message = sprintf($message ?: $format, self::valueToString($value));
            self::reportInvalidArgument($message);
        }

        return null;
    }
}
