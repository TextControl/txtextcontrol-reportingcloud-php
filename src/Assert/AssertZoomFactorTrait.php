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

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

/**
 * Trait AssertZoomFactorTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertZoomFactorTrait
{
    /**
     * @param int    $value
     * @param int    $min
     * @param int    $max
     * @param string $message
     */
    abstract public static function range($value, $min, $max, $message = '');

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
     * Check value is a valid zoom factor
     *
     * @param int    $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertZoomFactor(int $value, string $message = ''): void
    {
        $format  = $message ?: 'Zoom factor ("%s") must be in the range [%d..%d]';
        $message = sprintf($format, $value, self::$zoomFactorMin, self::$zoomFactorMax);

        self::range($value, self::$zoomFactorMin, self::$zoomFactorMax, $message);
    }
}
