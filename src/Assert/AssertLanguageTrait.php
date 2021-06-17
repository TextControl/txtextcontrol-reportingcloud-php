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
use TxTextControl\ReportingCloud\Stdlib\Path;

/**
 * Trait AssertLanguageTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertLanguageTrait
{
    use ValueToStringTrait;
    use AssertOneOfTrait;

    /**
     * Check value is a valid language
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
        $format   = 0 === strlen($message) ? '%1$s contains an unsupported language' : $message;
        $message  = sprintf($format, self::valueToString($value));

        self::assertOneOf($value, $haystack, $message);
    }

    /**
     * Return the filename, containing languages aka dictionaries array
     *
     * @return string
     */
    public static function getDictionariesFilename(): string
    {
        return sprintf('%1$s/dictionaries.php', Path::data());
    }

    /**
     * Return languages aka dictionaries array
     *
     * @return array<int, string>
     */
    private static function getDictionaries(): array
    {
        $filename = self::getDictionariesFilename();

        return (array) include $filename;
    }
}
