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
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait AssertTemplateFormatTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTemplateFormatTrait
{
    use ValueToStringTrait;
    use AssertOneOfTrait;

    /**
     * Check value is a valid template format
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertTemplateFormat(string $value, string $message = ''): void
    {
        $ucValue = strtoupper($value);

        $format  = 0 === strlen($message) ? '%1$s contains an unsupported template format file extension' : $message;
        $message = sprintf($format, self::valueToString($value));

        self::assertOneOf($ucValue, ReportingCloud::FILE_FORMATS_DOCUMENT, $message);
    }
}
