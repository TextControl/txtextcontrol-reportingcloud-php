<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://github.com/TextControl/txtextcontrol-reportingcloud-php/blob/master/LICENSE.md
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait AssertTemplateExtensionTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTemplateExtensionTrait
{
    /**
     * @param mixed  $value
     * @param array  $values
     * @param string $message
     */
    abstract public static function assertOneOf($value, array $values, string $message = ''): void;

    /**
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

    /**
     * Check value is a valid template extension
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertTemplateExtension(string $value, string $message = ''): void
    {
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        $extension = strtoupper($extension);

        $format  = $message ?: '%1$s contains an unsupported template format file extension';
        $message = sprintf($format, self::valueToString($value));

        self::assertOneOf($extension, ReportingCloud::FILE_FORMATS_TEMPLATE, $message);
    }
}
