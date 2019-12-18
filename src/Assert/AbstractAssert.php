<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://github.com/TextControl/txtextcontrol-reportingcloud-php/blob/master/LICENSE.md
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Abstract AbstractAssert
 *
 * This component is based on Webmozart\Assert.
 * See: https://github.com/webmozart/assert
 *
 * At the time of implementation (March 2019), the above component did not support strict types.
 * Since the ReportingCloud PHP SDK does support strict types, the necessary functions where cherry-picked from
 * Webmozart\Assert, strict typed, and insert into this component.
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
abstract class AbstractAssert
{
    /**
     * Convert value to string
     *
     * @param mixed $value
     *
     * @return string
     */
    protected static function valueToString($value): string
    {
        if (null === $value) {
            return 'null';
        }

        if (true === $value) {
            return 'true';
        }

        if (false === $value) {
            return 'false';
        }

        if (is_array($value)) {
            return 'array';
        }

        if (is_object($value)) {
            if (method_exists($value, '__toString')) {
                $format = '%1$s: %2$s';
                return sprintf($format, get_class($value), self::valueToString($value->__toString()));
            }
            return get_class($value);
        }

        if (is_resource($value)) {
            return 'resource';
        }

        if (is_string($value)) {
            $format = '"%1$s"';
            return sprintf($format, $value);
        }

        return (string) $value;
    }
}
