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

use TxTextControl\ReportingCloud\Validator\StaticValidator;

/**
 * BooleanToString filter
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class BooleanToString extends AbstractFilter
{
    /**
     * Convert boolean true and false to string 'true' and 'false'.
     *
     * This is necessary to prevent Guzzle from converting the query parameter to ?param=0 or ?param=1, which the
     * backend does not recognize.
     *
     * The backend only recognizes query parameter ?param=true and ?param=false.
     *
     * @param mixed $param Boolean value
     *
     * @return string
     */
    public function filter($param)
    {
        StaticValidator::execute($param, 'TypeBoolean');

        if (true === $param) {
            $ret = 'true';
        } else {
            $ret = 'false';
        }

        return $ret;
    }
}
