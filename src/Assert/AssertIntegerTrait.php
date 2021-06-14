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

/**
 * Trait AssertIntegerTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertIntegerTrait
{
    /**
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

    /**
     * Check value is an integer
     *
     * @param  mixed $value
     * @param string $message
     */
    public static function assertInteger($value, string $message = ''): void
    {
        if (!is_int($value)) {
            $format  = 0 === strlen($message) ? 'Expected an integer. Got: %1$s' : $message;
            $message = sprintf($format, self::valueToString($value));
            throw new InvalidArgumentException($message);
        }
    }
}
