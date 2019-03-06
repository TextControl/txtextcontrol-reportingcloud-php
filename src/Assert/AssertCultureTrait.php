<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Stdlib\Path;

/**
 * Trait AssertLanguageTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertCultureTrait
{
    /**
     * @param mixed  $value
     * @param array  $values
     * @param string $message
     */
    abstract public static function oneOf($value, array $values, string $message = ''): void;

    /**
     * Check value is a valid culture
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertCulture(string $value, string $message = ''): void
    {
        $haystack = self::getCultures();
        $format   = $message ?: '"%s" contains an unsupported culture';
        $message  = sprintf($format, $value);

        self::oneOf($value, $haystack, $message);
    }

    /**
     * Return the filename, containing cultures array
     *
     * @return string
     */
    public static function getCulturesFilename(): string
    {
        return sprintf('%s/cultures.php', Path::data());
    }

    /**
     * Return cultures array
     *
     * @return array
     * @psalm-suppress UnresolvableInclude
     */
    private static function getCultures(): array
    {
        $filename = self::getCulturesFilename();

        return (array) include $filename;
    }
}
