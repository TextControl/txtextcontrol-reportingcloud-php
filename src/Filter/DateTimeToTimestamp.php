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
     * Convert the date/time format used by the backend (e.g. "2016-04-15T19:05:18+00:00") to a UNIX timestamp.
     *
     * @param string $dateTimeString Backend formatted date/time string
     *
     * @return null|int
     */
    public function filter($dateTimeString)
    {
        $requiredLength = $this->getRequiredLength();

        if ($requiredLength !== strlen($dateTimeString)) {
            throw new InvalidArgumentException(
                sprintf('%s is an invalid date/time string - it must be exactly %d characters long',
                    $dateTimeString,
                    $requiredLength
                )
            );
        }

        $dateTimeFormat = self::REPORTING_CLOUD_DATE_FORMAT;
        $dateTimeZone   = new DateTimeZone(self::REPORTING_CLOUD_TIME_ZONE);

        $dateTime = DateTime::createFromFormat($dateTimeFormat, $dateTimeString, $dateTimeZone);

        if (false === $dateTime) {
            throw new InvalidArgumentException(
                sprintf('%s is an invalid date/time string - its syntax is invalid',
                    $dateTimeString)
            );
        }

        if (0 !== $dateTime->getOffset()) {
            throw new InvalidArgumentException(
                sprintf('%s is an invalid date/time string - its offset must be 0',
                    $dateTimeString
                )
            );
        }

        return $dateTime->getTimestamp();
    }

    /**
     * Return the required length (in characters) of the date/time string
     *
     * @return int
     */
    protected function getRequiredLength()
    {
        $dateTimeFormat = self::REPORTING_CLOUD_DATE_FORMAT;
        $dateTimeZone   = new DateTimeZone(self::REPORTING_CLOUD_TIME_ZONE);

        $dateTime = new DateTime('now', $dateTimeZone);

        return strlen($dateTime->format($dateTimeFormat));
    }
    
}
