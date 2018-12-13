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
 * Trait FilenameExistsTrait
 *
 * @package TxTextControl\ReportingCloud
 */
trait FilenameExistsTrait
{
    /**
     * Validate filename exists and can be read
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     * @throws TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public static function filenameExists(string $value, string $message = '')
    {
        if ($value !== realpath($value)) {
            $format  = '%s must contain the absolute path and file';
            $message = sprintf($message ?: $format, self::valueToString($value));
            self::reportInvalidArgument($message);
        }

        if (!is_file($value)) {
            $format  = '%s is not a regular file';
            $message = sprintf($message ?: $format, self::valueToString($value));
            self::reportInvalidArgument($message);
        }

        return null;
    }
}
