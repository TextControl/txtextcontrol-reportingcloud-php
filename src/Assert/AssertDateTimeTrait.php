<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2021 Text Control GmbH
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
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

    /**
     * Check value is a valid DateTime string
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
            $format  = $message ?: '%1$s has an invalid number of characters in it';
            $message = sprintf($format, self::valueToString($value));
            throw new InvalidArgumentException($message);
        }

        $dateTimeZone = new DateTimeZone($timeZone);

        try {
            $dateTime = DateTime::createFromFormat($dateFormat, $value, $dateTimeZone);
            if ($dateTime instanceof DateTime) {
                if (0 !== $dateTime->getOffset()) {
                    $format  = $message ?: '%1$s has an invalid offset';
                    $message = sprintf($format, self::valueToString($value));
                    throw new InvalidArgumentException($message);
                }
            } else {
                $format  = $message ?: '%1$s is syntactically invalid';
                $message = sprintf($format, self::valueToString($value));
                throw new InvalidArgumentException($message);
            }
        } catch (Exception $e) {
            $format  = $message ?: 'Internal error validating %1$s - %2$s';
            $message = sprintf($format, self::valueToString($value), self::valueToString($e->getMessage()));
            throw new InvalidArgumentException($message);
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

        unset($dateTimeZone);

        if (isset($dateTime)) {
            unset($dateTime);
        }

        return $ret;
    }
}
