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

/**
 * Class Assert
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Assert extends AbstractAssert
{
    use AssertApiKeyTrait;
    use AssertBase64DataTrait;
    use AssertCultureTrait;
    use AssertDateTimeTrait;
    use AssertDocumentDividerTrait;
    use AssertDocumentExtensionTrait;
    use AssertDocumentThumbnailExtensionTrait;
    use AssertImageFormatTrait;
    use AssertLanguageTrait;
    use AssertPageTrait;
    use AssertReturnFormatTrait;
    use AssertTemplateExtensionTrait;
    use AssertTemplateFormatTrait;
    use AssertTemplateNameTrait;
    use AssertTimestampTrait;
    use AssertZoomFactorTrait;
    use FilenameExistsTrait;

    /**
     * Check value is in values
     *
     * @param int|string $value
     * @param array      $values
     * @param string     $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function oneOf($value, array $values, string $message = ''): void
    {
        if (!in_array($value, $values, true)) {
            $format  = $message ?: 'Expected one of "%s". Got "%s"';
            $message = sprintf($format, implode('", "', $values), $value);
            throw new InvalidArgumentException($message);
        }
    }

    /**
     * Check value is in range min..max
     *
     * @param int    $value
     * @param int    $min
     * @param int    $max
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function range(int $value, int $min, int $max, string $message = ''): void
    {
        if ($value < $min || $value > $max) {
            $format  = $message ?: 'Expected a value between "%d" and "%d". Got: "%d"';
            $message = sprintf($format, $min, $max, $value);
            throw new InvalidArgumentException($message);
        }
    }

    /**
     * Check value is an array
     *
     * @param        $value
     * @param string $message
     */
    public static function isArray($value, string $message = ''): void
    {
        if (!is_array($value)) {
            $format  = $message ?: 'Expected an array. Got: "%s"';
            $message = sprintf($format, $value);
            throw new InvalidArgumentException($message);
        }
    }

    /**
     * Check value is a string
     *
     * @param        $value
     * @param string $message
     */
    public static function string($value, string $message = ''): void
    {
        if (!is_string($value)) {
            $format  = $message ?: 'Expected a string. Got: "%s"';
            $message = sprintf($format, $value);
            throw new InvalidArgumentException($message);
        }
    }

    /**
     * Check value is an integer
     *
     * @param        $value
     * @param string $message
     */
    public static function integer($value, string $message = ''): void
    {
        if (!is_int($value)) {
            $format  = $message ?: 'Expected an integer. Got: "%s"';
            $message = sprintf($format, $value);
            throw new InvalidArgumentException($message);
        }
    }

    /**
     * Check value is a boolean
     *
     * @param        $value
     * @param string $message
     */
    public static function boolean($value, string $message = ''): void
    {
        if (!is_bool($value)) {
            $format  = $message ?: 'Expected a boolean. Got: "%s"';
            $message = sprintf($format, $value);
            throw new InvalidArgumentException($message);
        }
    }
}
