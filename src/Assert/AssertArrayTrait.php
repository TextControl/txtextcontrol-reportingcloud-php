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
 * Trait AssertArrayTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 *
 * @deprecated Not necessary in PHP 7.4
 */
trait AssertArrayTrait
{
    use ValueToStringTrait;

    /**
     * Check value is an array
     *
     * @param mixed  $value
     * @param string $message
     */
    public static function assertArray($value, string $message = ''): void
    {
        if (!is_array($value)) {
            $format  = 0 === strlen($message) ? 'Expected an array. Got: %1$s' : $message;
            $message = sprintf($format, self::valueToString($value));
            throw new InvalidArgumentException($message);
        }
    }
}
