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
namespace TxTextControl\ReportingCloud\Validator;

use TxTextControl\ReportingCloud\ReportingCloud;

use Zend\Validator\AbstractValidator  as ZendAbstractValidator;
use Zend\Validator\ValidatorInterface as ZendValidatorInterface;

/**
 * Abstract validator
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
abstract class AbstractValidator extends ZendAbstractValidator implements ZendValidatorInterface
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
