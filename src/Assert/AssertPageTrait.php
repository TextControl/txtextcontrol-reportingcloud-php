<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertPageTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertPageTrait
{
    /**
     * Minimum page
     *
     * @var int
     */
    private static $assertPageMinimum = 1;

    /**
     * Validate page
     *
     * @param int    $value
     * @param string $message
     *
     * @return null
     */
    public static function assertPage(int $value, string $message = '')
    {
        if ($value < self::$assertPageMinimum) {
            $format  = '%s contains an invalid page number';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
