<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertApiKeyTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertApiKeyTrait
{
    /**
     * Maximum length of API key
     *
     * @var int
     */
    private static $assertApiKeyMinimumLength = 20;

    /**
     * Minimum length of API key
     *
     * @var int
     */
    private static $assertApiKeyMaximumLength = 45;

    /**
     * Validate length of API key
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertApiKey(string $value, string $message = '')
    {
        $length = strlen($value);

        if ($length < self::$assertApiKeyMinimumLength) {
            $format  = '%s is an invalid API key -- too short';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        if ($length > self::$assertApiKeyMaximumLength) {
            $format  = '%s is an invalid API key -- too long';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
