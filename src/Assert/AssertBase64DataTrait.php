<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertBase64DataTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertBase64DataTrait
{
    /**
     * Validate base64 data
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertBase64Data(string $value, string $message = '')
    {
        if (!base64_decode($value, true)) {
            $format  = '%s must be base64 encoded';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
