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
    abstract public static function range($value, $min, $max, $message = '');

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

        $format  = $message ?: 'Length of API key ("%s") must be in the range [%d..%d]';
        $message = sprintf($format, $value, self::$apiKeyMinLength, self::$apiKeyMaxLength);

        self::range($len, self::$apiKeyMinLength, self::$apiKeyMaxLength, $message);
    }
}
