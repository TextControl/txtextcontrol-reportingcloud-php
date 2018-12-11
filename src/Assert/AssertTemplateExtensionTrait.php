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
 * Trait AssertTemplateExtensionTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertTemplateExtensionTrait
{


    /**
     * Validate template extension
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertTemplateExtension(string $value, string $message = '')
    {
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        $extension = strtoupper($extension);

        if (!in_array($extension, self::$templateFormats)) {
            $format  = '%s contains an unsupported template format file extension';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
