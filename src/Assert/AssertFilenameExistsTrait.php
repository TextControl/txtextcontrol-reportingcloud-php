<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertFilenameExistsTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertFilenameExistsTrait
{
    /**
     * Validate filename exists and can be read
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertFilenameExists(string $value, string $message = '')
    {
        if (!file_exists($value) || !is_readable($value)) {
            $format  = '%s contains an invalid filename';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
