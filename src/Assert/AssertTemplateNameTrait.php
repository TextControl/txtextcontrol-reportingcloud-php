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

use InvalidArgumentException;

/**
 * Trait AssertTemplateNameTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertTemplateNameTrait
{
    public static function assertTemplateName(string $value, string $message = '')
    {
        if (basename($value) != $value) {
            $format  = "%s contains path information ('/', '.', or '..')";
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        $basename  = pathinfo($value, PATHINFO_BASENAME);
        $extension = pathinfo($value, PATHINFO_EXTENSION);

        if (0 === strlen($basename) || $basename == ".{$extension}") {
            $format  = "%s contains an invalid file basename";
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        if (0 === strlen($extension)) {
            $format  = "%s contains an invalid file extension";
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        try {
            self::assertTemplateFormat($extension);
        } catch (InvalidArgumentException $e) {
            $format  = "%s contains an unsupported file extension";
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
