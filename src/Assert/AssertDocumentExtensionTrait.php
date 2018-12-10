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
    private static $assertDocumentExtensionHaystack
        = [
            'DOC',
            'DOCX',
            'HTML',
            'PDF',
            'RTF',
            'TX',
        ];

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
        if (!in_array(strtoupper($value), self::$assertDocumentExtensionHaystack)) {
            $format  = '%s contains an unsupported document format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
