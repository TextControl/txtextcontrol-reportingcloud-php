<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertTemplateFormatTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertTemplateFormatTrait
{
    private static $assertTemplateFormatHaystack
        = [
            'DOC',
            'DOCX',
            'RTF',
            'TX',
        ];

    /**
     * Validate template format
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertTemplateFormat(string $value, string $message = '')
    {
        if (!in_array(strtoupper($value), self::$assertTemplateFormatHaystack)) {
            $format  = '%s contains an unsupported template format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
