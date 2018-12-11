<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertApiKeyTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertApiKeyTrait
{
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

        if ($length < self::$apiKeyMinLength || $length > self::$apiKeyMaxLength) {
            $format  = 'API key must between %s and %s characters in length';
            $message = sprintf($message ?: $format,
                               static::valueToString(self::$apiKeyMinLength),
                               static::valueToString(self::$apiKeyMaxLength));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
