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
 * Trait AssertLanguageTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertCultureTrait
{
    /**
     * Validate culture
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
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
        $filename = dirname(__FILE__, 3) . '/data/cultures.php';

        return $filename;
    }

    /**
     * Return cultures array
     *
     * @return array
     */
    private static function getCultures(): array
    {
        $filename = self::getCulturesFilename();

        return (array) include $filename;
    }
}
