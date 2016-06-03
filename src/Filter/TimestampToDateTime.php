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

/**
 * TimestampToDateTime filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TimestampToDateTime extends AbstractFilter
{
    /**
     * Convert a UNIX timestamp to a date/time string for return to the backend
     *
     * Note: The 'ISO 8601' formatted date/time string returned by the backend does not have any timezone information in
     *       it. i.e. it returns '2016-06-02T15:49:57' and not '2016-06-02T15:49:57+00:00'. Therefore, this method
     *       returns the date/time string also devoid of timezone information.
     *
     * @param $value UNIX timestamp
     *
     * @return null|string
     */
    public function filter($value)
    {
        $ret = null;

        if (is_numeric($value)) {

            $dateTime = date('c', $value);
            $dateTime = strtok($dateTime, '+'); // remove timezone

            if (is_string($dateTime)) {
                $ret = $dateTime;
            }
        }

        return $ret;
    }
}