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
        $ucValue = strtoupper($value);

        if (!in_array($ucValue, self::$templateFormats)) {
            $format  = '%s contains an unsupported template format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
