<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

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

/**
 * Trait AssertZoomFactorTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertZoomFactorTrait
{
    /**
     * Minimum zoom factor
     *
     * @var int
     */
    private static $zoomFactorMin = 1;

    /**
     * Maximum zoom factor
     *
     * @var int
     */
    private static $zoomFactorMax = 400;

    /**
     * Validate zoom factor
     *
     * @param int    $value
     * @param string $message
     *
     * @return null
     */
    public static function assertZoomFactor(int $value, string $message = '')
    {
        if ($value < self::$zoomFactorMin || $value > self::$zoomFactorMax) {
            $format  = 'Zoom factor must be in the range [%d..%d]';
            $message = sprintf($message ?: $format,
                               static::valueToString(self::$zoomFactorMin),
                               static::valueToString(self::$zoomFactorMax));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
