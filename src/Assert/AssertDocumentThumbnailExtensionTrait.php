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
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait AssertDocumentThumbnailExtensionTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertDocumentThumbnailExtensionTrait
{
    /**
     * @param mixed  $value
     * @param array  $values
     * @param string $message
     */
    abstract public static function assertOneOf($value, array $values, string $message = ''): void;

    /**
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

    /**
     * Check value is a valid document thumbnail format extension
     *
     * This is a special case assert method that is used only by
     * TxTextControl\ReportingCloud\ReportingCloud::getDocumentThumbnails()
     * as this method additionally accepts files in XLSX format. No other methods do.
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertDocumentThumbnailExtension(string $value, string $message = ''): void
    {
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        $extension = strtoupper($extension);

        $format  = $message ?: '%1$s contains an unsupported document thumbnail format file extension';
        $message = sprintf($format, self::valueToString($value));

        $fileFormats = array_merge(
            ReportingCloud::FILE_FORMATS_DOCUMENT,
            [
                ReportingCloud::FILE_FORMAT_XLSX
            ]
        );

        self::assertOneOf($extension, $fileFormats, $message);
    }
}
