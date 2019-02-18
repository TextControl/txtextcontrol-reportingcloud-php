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
 * Trait AssertLanguageTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertLanguageTrait
{
    /**
     * Validate language
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertLanguage(string $value, string $message = ''): void
    {
        $haystack = self::getDictionaries();
        $format   = $message ?: '"%s" contains an unsupported language';
        $message  = sprintf($format, $value);

        self::oneOf($value, $haystack, $message);
    }

    /**
     * Return the filename, containing languages aka dictionaries array
     *
     * @return string
     */
    public static function getDictionariesFilename(): string
    {
        $filename = dirname(__FILE__, 3) . '/data/dictionaries.php';

        return $filename;
    }

    /**
     * Return languages aka dictionaries array
     *
     * @return array
     * @psalm-suppress UnresolvableInclude
     */
    private static function getDictionaries(): array
    {
        $filename = self::getDictionariesFilename();

        return (array) include $filename;
    }
}
