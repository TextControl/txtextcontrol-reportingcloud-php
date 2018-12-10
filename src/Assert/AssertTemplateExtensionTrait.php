<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertTemplateExtensionTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertTemplateExtensionTrait
{


    /**
     * Validate template extension
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertTemplateExtension(string $value, string $message = '')
    {
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        $extension = strtoupper($extension);

        if (!in_array($extension, self::$templateFormats)) {
            $format  = '%s contains an unsupported template format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
