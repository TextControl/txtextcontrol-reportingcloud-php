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
 * @copyright © 2022 Text Control GmbH
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
    use ValueToStringTrait;
    use AssertRangeTrait;

    /**
     * Minimum length of API key
     *
     * @var int
     */
    private static int $apiKeyMinLength = 20;

    /**
     * Maximum length of API key
     *
     * @var int
     */
    private static int $apiKeyMaxLength = 45;

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

        $format  = 0 === strlen($message) ? 'Length of API key (%1$s) must be in the range [%2$s..%3$s]' : $message;
        $message = sprintf(
            $format,
            self::valueToString($value),
            self::valueToString(self::$apiKeyMinLength),
            self::valueToString(self::$apiKeyMaxLength)
        );

        self::assertRange($len, self::$apiKeyMinLength, self::$apiKeyMaxLength, $message);
    }
}
