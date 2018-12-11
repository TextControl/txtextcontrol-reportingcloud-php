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

/**
 * Trait AssertLanguageTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertCultureTrait
{
    /**
     * Validate culture
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertCulture(string $value, string $message = '')
    {
        $filename = realpath(__DIR__ . '/../../data/cultures.php');

        if (!is_readable($filename)) {
            $format  = 'Internal error validating %s';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        $haystack = include $filename;

        if (!in_array($value, $haystack)) {
            $format  = '%s contains an unsupported culture';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
