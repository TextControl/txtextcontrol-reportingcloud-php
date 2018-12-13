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
        $haystack = include self::getDictionariesFilename();
        $format   = '%s contains an unsupported language';
        $message  = sprintf($message ?: $format, self::valueToString($value));

        return self::oneOf($value, $haystack, $message);
    }

    /**
     * Return resource filename, containing languages array
     *
     * @return string
     */
    public static function getDictionariesFilename(): string
    {
        $filename = __DIR__ . '/../../data/dictionaries.php';

        if (is_readable($filename)) {
            $filename = realpath($filename);
        }

        return $filename;
    }
}
