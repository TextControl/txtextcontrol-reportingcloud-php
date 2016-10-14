<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud\Filter;

use DateTime;
use DateTimeZone;
use TxTextControl\ReportingCloud\Validator\StaticValidator;

/**
 * TimestampToDateTime filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TimestampToDateTime extends AbstractFilter
{
    /**
     * Convert a UNIX timestamp to the date/time format used by the backend (e.g. "2016-04-15T19:05:18+00:00").
     *
     * @param mixed $timestamp UNIX timestamp
     *
     * @return string
     */
    public function filter($timestamp)
    {
        StaticValidator::execute($timestamp, 'Timestamp');

        $dateTimeZone = new DateTimeZone($this->getTimeZone());
        $dateTime     = new DateTime();

        $dateTime->setTimestamp($timestamp);
        $dateTime->setTimezone($dateTimeZone);

        return $dateTime->format($this->getDateFormat());
    }
}
