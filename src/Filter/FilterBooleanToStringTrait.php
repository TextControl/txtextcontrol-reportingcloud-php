<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Filter;

/**
 * Trait FilterBooleanToStringTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
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
        return $param ? 'true' : 'false';
    }
}
