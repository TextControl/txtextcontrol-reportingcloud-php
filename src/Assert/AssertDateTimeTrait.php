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
use Exception;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait AssertDateTimeTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertDateTimeTrait
{
    /**
     * @param string $message
     */
    abstract protected static function reportInvalidArgument($message): void;

    /**
     * Validate DateTime string
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertDateTime(string $value, string $message = ''): void
    {
        $timeZone   = ReportingCloud::DEFAULT_TIME_ZONE;
        $dateFormat = ReportingCloud::DEFAULT_DATE_FORMAT;

        if (self::getDateTimeLength() !== strlen($value)) {
            $format  = $message ?: '"%s" has an invalid number of characters in it';
            $message = sprintf($format, $value);
            self::reportInvalidArgument($message);
        }

        $dateTimeZone = new DateTimeZone($timeZone);

        try {
            $dateTime = DateTime::createFromFormat($dateFormat, $value, $dateTimeZone);
            if ($dateTime instanceof DateTime) {
                if (0 !== $dateTime->getOffset()) {
                    $format  = $message ?: '"%s" has an invalid offset';
                    $message = sprintf($format, $value);
                    self::reportInvalidArgument($message);
                }
            } else {
                $format  = $message ?: '"%s" is syntactically invalid';
                $message = sprintf($format, $value);
                self::reportInvalidArgument($message);
            }
        } catch (Exception $e) {
            $format  = $message ?: 'Internal error validating "%s" - %s';
            $message = sprintf(
                $format,
                $value,
                $e->getMessage()
            );
            self::reportInvalidArgument($message);
        }
    }

    /**
     * Get the length of the required dateTime string
     *
     * @return int
     */
    private static function getDateTimeLength()
    {
        $ret = 0;

        $timeZone   = ReportingCloud::DEFAULT_TIME_ZONE;
        $dateFormat = ReportingCloud::DEFAULT_DATE_FORMAT;

        $dateTimeZone = new DateTimeZone($timeZone);

        try {
            $dateTime = new DateTime('now', $dateTimeZone);
            $ret      = strlen($dateTime->format($dateFormat));
        } catch (Exception $e) {
            // continue;
        }

        unset($dateTimeZone, $dateTime);

        return $ret;
    }
}
