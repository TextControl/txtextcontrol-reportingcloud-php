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

namespace TxTextControl\ReportingCloud\Filter2;

use DateTime;
use DateTimeZone;
use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait FilterDateTimeToTimestampTrait
 *
 * @package TxTextControl\ReportingCloud
 */
trait FilterDateTimeToTimestampTrait
{
    /**
     * Convert the date/time format used by the backend (e.g. "2016-04-15T19:05:18+00:00") to a UNIX timestamp.
     *
     * @param string $dateTimeString
     *
     * @return int
     * @throws \Exception
     */
    public static function filterDateTimeToTimestamp(string $dateTimeString): int
    {
        Assert::assertDateTime($dateTimeString);

        $timeZone   = ReportingCloud::DEFAULT_TIME_ZONE;
        $dateFormat = ReportingCloud::DEFAULT_DATE_FORMAT;

        $dateTimeZone = new DateTimeZone($timeZone);
        $dateTime     = DateTime::createFromFormat($dateFormat, $dateTimeString, $dateTimeZone);

        return $dateTime->getTimestamp();
    }
}
