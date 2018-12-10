<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertLanguageTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertLanguageTrait
{
    /**
     * Validate language
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertLanguage(string $value, string $message = '')
    {
        $filename = realpath(__DIR__ . '/../../data/dictionaries.php');

        if (!is_readable($filename)) {
            $format  = 'Internal error validating %s';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        $haystack = include $filename;

        if (!in_array($value, $haystack)) {
            $format  = '%s contains an unsupported language';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
