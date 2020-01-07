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
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait AssertRangeTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertRangeTrait
{
    /**
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

    /**
     * Check value is in range min..max
     *
     * @param int    $value
     * @param int    $min
     * @param int    $max
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertRange(int $value, int $min, int $max, string $message = ''): void
    {
        if ($value < $min || $value > $max) {
            $format  = $message ?: 'Expected a value between %2$s and %3$s. Got: %1$s';
            $message = sprintf(
                $format,
                self::valueToString($value),
                self::valueToString($min),
                self::valueToString($max)
            );
            throw new InvalidArgumentException($message);
        }
    }
}
