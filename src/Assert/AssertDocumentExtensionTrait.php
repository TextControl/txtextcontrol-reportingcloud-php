<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertDocumentExtensionTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertDocumentExtensionTrait
{
    /**
     * Validate document format extension
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertDocumentExtension(string $value, string $message = '')
    {
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        $extension = strtoupper($extension);

        if (!in_array($extension, self::$documentFormats)) {
            $format  = '%s contains an unsupported document format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
