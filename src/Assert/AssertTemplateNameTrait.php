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
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTemplateNameTrait
{
    /**
     * Validate template format
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    abstract public static function assertTemplateFormat(string $value, string $message = '');

    /**
     * Validate template name
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public static function assertTemplateName(string $value, string $message = '')
    {
        if (basename($value) != $value) {
            $format  = $message ?: "%s contains path information ('/', '.', or '..')";
            $message = sprintf($format, self::valueToString($value));
            self::reportInvalidArgument($message);
        }

        $extension = pathinfo($value, PATHINFO_EXTENSION);

        try {
            self::assertTemplateFormat($extension);
        } catch (InvalidArgumentException $e) {
            $format  = $message ?: "%s contains an unsupported file extension";
            $message = sprintf($format, self::valueToString($value));
            self::reportInvalidArgument($message);
        }

        return null;
    }
}
