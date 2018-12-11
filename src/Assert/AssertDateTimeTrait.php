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

use DateTime;
use DateTimeZone;
use Throwable;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait AssertDateTimeTrait
 *
 * @package TxTextControl\ReportingCloud
 */
trait AssertDateTimeTrait
{
    /**
     * Validate DateTime string
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertDateTime(string $value, string $message = '')
    {
        $timeZone   = ReportingCloud::DEFAULT_TIME_ZONE;
        $dateFormat = ReportingCloud::DEFAULT_DATE_FORMAT;

        $dateTimeZone = new DateTimeZone($timeZone);

        try {
            $dateTime = new DateTime('now', $dateTimeZone);
            if (strlen($dateTime->format($dateFormat)) !== strlen($value)) {
                $format  = '%s has an invalid number of characters in it';
                $message = sprintf($message ?: $format, static::valueToString($value));
                static::reportInvalidArgument($message);
            }
        } catch (Throwable $e) {
            $format  = 'Internal error validating %s';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        try {
            $dateTime = DateTime::createFromFormat($dateFormat, $value, $dateTimeZone);
            if (!$dateTime) {
                $format  = '%s is syntactically invalid';
                $message = sprintf($message ?: $format, static::valueToString($value));
                static::reportInvalidArgument($message);
            }
            if (0 !== $dateTime->getOffset()) {
                $format  = '%s has an invalid offset';
                $message = sprintf($message ?: $format, static::valueToString($value));
                static::reportInvalidArgument($message);
            }
        } catch (Throwable $e) {
            $format  = 'Internal error validating %s';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
