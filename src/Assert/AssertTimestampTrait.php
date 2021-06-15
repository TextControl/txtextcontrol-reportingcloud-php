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
 * Trait AssertTimestampTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTimestampTrait
{
    use ValueToStringTrait;
    use AssertRangeTrait;

    /**
     * Minimum timestamp (EPOC)
     *
     * @var int
     */
    private static int $timestampMin = 0;

    /**
     * Maximum timestamp (PHP_INT_MAX)
     *
     * @var int
     */
    private static int $timestampMax = PHP_INT_MAX;

    /**
     * Check value is a valid timestamp
     *
     * @param int    $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertTimestamp(int $value, string $message = ''): void
    {
        $format  = 0 === strlen($message) ? 'Timestamp (%1$s) must be in the range [%2$s..%3$s]' : $message;
        $message = sprintf(
            $format,
            self::valueToString($value),
            self::valueToString(self::$timestampMin),
            self::valueToString(self::$timestampMax)
        );

        self::assertRange($value, self::$timestampMin, self::$timestampMax, $message);
    }
}
