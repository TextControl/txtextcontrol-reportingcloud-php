<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertTimestampTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertTimestampTrait
{
    /**
     * Minimum timestamp
     *
     * @var int
     */
    private static $assertTimestampMinimum = 0;

    /**
     * Validate timestamp
     *
     * @param int    $value
     * @param string $message
     *
     * @return null
     */
    public static function assertTimestamp(int $value, string $message = '')
    {
        if ($value < self::$assertTimestampMinimum) {
            $format  = '%s is an invalid timestamp -- too small';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        if ($value > PHP_INT_MAX) {
            $format  = '%s is an invalid timestamp -- too large';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
