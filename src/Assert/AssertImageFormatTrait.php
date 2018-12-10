<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertImageFormatTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertImageFormatTrait
{
    private static $assertImageFormatHaystack
        = [
            'BMP',
            'GIF',
            'JPG',
            'PNG',
        ];

    /**
     * Validate image format extension
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertImageFormat(string $value, string $message = '')
    {
        if (!in_array(strtoupper($value), self::$assertImageFormatHaystack)) {
            $format  = '%s contains an unsupported image format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
