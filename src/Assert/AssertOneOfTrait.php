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
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait AssertOneOfTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertOneOfTrait
{
    /**
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

    /**
     * Check value is in values
     *
     * @param mixed  $value
     * @param array  $values
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertOneOf($value, array $values, string $message = ''): void
    {
        if (!in_array($value, $values, true)) {
            $array = [];
            foreach ($values as $key => $record) {
                $array[$key] = self::valueToString($record);
            }
            $valuesString = implode(', ', $array);
            $format       = $message ?: 'Expected one of %2$s. Got %1$s';
            $message      = sprintf($format, self::valueToString($value), $valuesString);
            throw new InvalidArgumentException($message);
        }
    }
}
