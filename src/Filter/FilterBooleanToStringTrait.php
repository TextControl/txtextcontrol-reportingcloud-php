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

namespace TxTextControl\ReportingCloud\Filter;

use TxTextControl\ReportingCloud\Assert\Assert;

/**
 * Trait FilterBooleanToStringTrait
 *
 * @package TxTextControl\ReportingCloud
 */
trait FilterBooleanToStringTrait
{
    /**
     * Convert bool true and false to string 'true' and 'false'.
     *
     * This is necessary to prevent Guzzle from converting the query parameter to ?param=0 or ?param=1, which the
     * backend does not recognize.
     *
     * The backend only recognizes query parameter ?param=true and ?param=false.
     *
     * @param bool $param
     *
     * @return string
     */
    public static function filterBooleanToString(bool $param): string
    {
        Assert::boolean($param);

        return ($param) ? 'true' : 'false';
    }
}
