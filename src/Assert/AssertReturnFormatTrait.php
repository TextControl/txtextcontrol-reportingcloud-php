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

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
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
     * Check value is a valid return format extension
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertReturnFormat(string $value, string $message = ''): void
    {
        $ucValue = strtoupper($value);

        $format  = $message ?: '%1$s contains an unsupported return format file extension';
        $message = sprintf($format, self::valueToString($value));

        self::assertOneOf($ucValue, ReportingCloud::FILE_FORMATS_RETURN, $message);
    }
}
