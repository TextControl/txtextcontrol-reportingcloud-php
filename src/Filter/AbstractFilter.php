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

use TxTextControl\ReportingCloud\ReportingCloud;
use Zend\Filter\AbstractFilter as AbstractFilterFilterZend;

/**
 * Abstract filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
abstract class AbstractFilter extends AbstractFilterFilterZend
{
    /**
     * Return backend date format
     *
     * @return string
     */
    protected function getDateFormat()
    {
        return ReportingCloud::DEFAULT_DATE_FORMAT;
    }

    /**
     * Return backend time zone
     *
     * @return string
     */
    protected function getTimeZone()
    {
        return ReportingCloud::DEFAULT_TIME_ZONE;
    }
}
