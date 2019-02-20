<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait FilenameExistsTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait FilenameExistsTrait
{
    /**
     * @param string $message
     */
    abstract protected static function reportInvalidArgument($message): void;

    /**
     * Check filename exists and is readable
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function filenameExists(string $value, string $message = ''): void
    {
        if (!is_readable($value)) {
            $format  = $message ?: '"%s" does not exist or is not readable';
            $message = sprintf($format, $value);
            self::reportInvalidArgument($message);
        }

        if (!is_file($value)) {
            $format  = $message ?: '"%s" is not a regular file';
            $message = sprintf($format, $value);
            self::reportInvalidArgument($message);
        }
    }
}
