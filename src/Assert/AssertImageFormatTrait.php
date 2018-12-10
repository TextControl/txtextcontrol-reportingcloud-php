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
        $ucValue = strtoupper($value);

        if (!in_array($ucValue, self::$imageFormats)) {
            $format  = '%s contains an unsupported image format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
