<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait AssertApiKeyTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertApiKeyTrait
{
    /**
     * @param int    $value
     * @param int    $min
     * @param int    $max
     * @param string $message
     */
    abstract public static function assertRange(int $value, int $min, int $max, string $message = ''): void;

    /**
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

    /**
     * Minimum length of API key
     *
     * @var int
     */
    private static $apiKeyMinLength = 20;

    /**
     * Maximum length of API key
     *
     * @var int
     */
    private static $apiKeyMaxLength = 45;

    /**
     * Check value is a syntactically valid API key
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertApiKey(string $value, string $message = ''): void
    {
        $len = strlen($value);

        $format  = $message ?: 'Length of API key (%1$s) must be in the range [%2$s..%3$s]';
        $message = sprintf(
            $format,
            self::valueToString($value),
            self::valueToString(self::$apiKeyMinLength),
            self::valueToString(self::$apiKeyMaxLength)
        );

        self::assertRange($len, self::$apiKeyMinLength, self::$apiKeyMaxLength, $message);
    }
}
