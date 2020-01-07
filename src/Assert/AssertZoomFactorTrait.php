<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2020 Text Control GmbH
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
    abstract public static function assertRange(int $value, int $min, int $max, string $message = ''): void;

    /**
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

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
        $format  = $message ?: 'Zoom factor (%1$s) must be in the range [%2$s..%3$s]';
        $message = sprintf(
            $format,
            self::valueToString($value),
            self::valueToString(self::$zoomFactorMin),
            self::valueToString(self::$zoomFactorMax)
        );

        self::assertRange($value, self::$zoomFactorMin, self::$zoomFactorMax, $message);
    }
}
