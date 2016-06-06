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
     * ISO 8601 format
     *
     * Note, last letter is 'P' and not 'O':
     *
     * O - Difference to Greenwich time (GMT) in hours (e.g. +0200)
     * P - Difference to Greenwich time (GMT) with colon between hours and minutes (e.g. +02:00)
     *
     * Backend uses the 'P' variant
     *
     * @const REPORTING_CLOUD_DATE_FORMAT
     */
    const REPORTING_CLOUD_DATE_FORMAT = 'Y-m-d\TH:i:sP';

    /**
     * Time zone of backend server, according to a statement by backend developers on June 06, 2016
     *
     * @const REPORTING_CLOUD_TIME_ZONE
     */
    const REPORTING_CLOUD_TIME_ZONE = 'UTC';

}
