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

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait AssertReturnFormatTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertReturnFormatTrait
{
    /**
     * Validate return format extension
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public static function assertReturnFormat(string $value, string $message = ''): void
    {
        $ucValue = strtoupper($value);

        $format  = $message ?: '"%s" contains an unsupported return format file extension';
        $message = sprintf($format, $value);

        self::oneOf($ucValue, ReportingCloud::FILE_FORMATS_RETURN, $message);
    }
}
