<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud\Filter;

use DateTime;
use DateTimeZone;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * DateTimeToTimestamp filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class DateTimeToTimestamp extends AbstractFilter
{
    /**
     * Length of date/time string returned by backend
     *
     * @const DATE_TIME_STRING_LENGTH
     */
    const DATE_TIME_STRING_LENGTH = 19;

    /**
     * Convert a date/time string returned from the backend to a UNIX timestamp.
     *
     * Note: The 'ISO 8601' formatted date/time string, returned by the backend, does not have any timezone information
     *       in it. i.e. it returns '2016-06-02T15:49:57' and not '2016-06-02T15:49:57+00:00'.
     *
     * @param string $value 'ISO 8601' formatted date/time string, minus timezone, for example, '2016-06-02T15:49:57'
     *
     * @return null|int
     */
    public function filter($value)
    {
        $value = (string) $value;

        if (self::DATE_TIME_STRING_LENGTH != strlen($value)) {
            throw new InvalidArgumentException(
                sprintf('%s is an invalid date/time string - it must have exactly %d characters',
                    self::DATE_TIME_STRING_LENGTH,
                    $value)
            );
        }

        $dateTimeFormat = DateTime::ISO8601;
        $dateTimeString = $this->addTimeZone($value);
        $dateTimeZone   = new DateTimeZone('UTC');

        $dateTime = DateTime::createFromFormat($dateTimeFormat, $dateTimeString, $dateTimeZone);

        if (false === $dateTime) {
            throw new InvalidArgumentException(
                sprintf('%s is an invalid date/time string',
                    $value)
            );
        }

        return $dateTime->getTimestamp();
    }

    /**
     * Add timezone information to a date/time sting.
     *
     * @param string $dateTimeString Date/time string to which to add the time zone information.
     *
     * @return string
     */
    protected function addTimeZone($dateTimeString)
    {
        $dateTimeString = sprintf('%s+00:00', $dateTimeString);

        return $dateTimeString;

    }
}
