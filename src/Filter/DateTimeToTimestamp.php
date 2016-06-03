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
 * DateTimeToTimestamp filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class DateTimeToTimestamp extends AbstractFilter
{
    /**
     * Convert a date/time string returned from the backend to a UNIX timestamp.
     *
     * Note: The 'ISO 8601' formatted date/time string, returned by the backend, does not have any timezone information
     *       in it. i.e. it returns '2016-06-02T15:49:57' and not '2016-06-02T15:49:57+00:00'.
     *
     * @param $value 'ISO 8601' formatted date/time string, minus timezone, for example, '2016-06-02T15:49:57'
     *
     * @return null|int
     */
    public function filter($value)
    {
        $ret = null;

        $timestamp = strtotime("{$value}+00:00");

        if (is_integer($timestamp)) {
            $ret = $timestamp;
        }

        return $ret;
    }

}