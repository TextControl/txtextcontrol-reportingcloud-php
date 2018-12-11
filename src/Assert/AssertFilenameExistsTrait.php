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
 * Trait AssertFilenameExistsTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertFilenameExistsTrait
{
    /**
     * Validate filename exists and can be read
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertFilenameExists(string $value, string $message = '')
    {
        if (!file_exists($value) || !is_readable($value)) {
            $format  = '%s contains an invalid filename';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
