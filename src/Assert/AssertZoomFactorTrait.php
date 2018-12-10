<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertZoomFactorTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertZoomFactorTrait
{
    /**
     * Minimum zoom factor
     *
     * @var int
     */
    private static $assertZoomFactorMinimum = 1;

    /**
     * Maximum zoom factor
     *
     * @var int
     */
    private static $assertZoomFactorMaximum = 400;

    /**
     * Validate zoom factor
     *
     * @param int    $value
     * @param string $message
     *
     * @return null
     */
    public static function assertZoomFactor(int $value, string $message = '')
    {
        if ($value < self::$assertZoomFactorMinimum) {
            $format  = '%s is an invalid zoom factor -- too small';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        if ($value > self::$assertZoomFactorMaximum) {
            $format  = '%s is an invalid zoom factor -- too large';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
