<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertReturnFormatTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertReturnFormatTrait
{
    /**
     * Validate return format extension
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertReturnFormat(string $value, string $message = '')
    {
        $ucValue = strtoupper($value);

        if (!in_array($ucValue, self::$returnFormats)) {
            $format  = '%s contains an unsupported return format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
