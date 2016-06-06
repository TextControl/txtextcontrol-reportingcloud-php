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
use Exception;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * TimestampToDateTime filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TimestampToDateTime extends AbstractFilter
{
    /**
     * Convert a UNIX timestamp to a date/time string for return to the backend.
     *
     * Note: The 'ISO 8601' formatted date/time string returned by the backend does not have any timezone information in
     *       it. i.e. it returns '2016-06-02T15:49:57' and not '2016-06-02T15:49:57+00:00'. Therefore, this method
     *       returns the date/time string also devoid of timezone information.
     *
     * @param integer $value UNIX timestamp
     *
     * @return null|string
     */
    public function filter($value)
    {
        $dateTimeString = null;

        if (!is_numeric($value) || $value < 0) {
            throw new InvalidArgumentException(
                sprintf('%s is an invalid unix timestamp integer - it must be greater than 0',
                    $value)
            );
        }

        try {

            $dateTimeFormat = DateTime::ISO8601;

            $dateTimeZone   = new DateTimeZone('UTC');
            $dateTime       = new DateTime();

            $dateTime->setTimestamp($value);
            $dateTime->setTimezone($dateTimeZone);

            $dateTimeString = $dateTime->format($dateTimeFormat);
            $dateTimeString = $this->removeTimeZone($dateTimeString);

        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf('%s is an invalid unix timestamp integer', $value)
            );
        }

        return $dateTimeString;

    }

    /**
     * Remove timezone information from a date/time sting.
     *
     * @param string $dateTimeString Date/time string from which to remove the time zone information.
     *
     * @return string
     */
    protected function removeTimeZone($dateTimeString)
    {
        $dateTimeString = strtok($dateTimeString, '+');

        return $dateTimeString;

    }
}
