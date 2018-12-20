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
 * Trait AssertPageTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertPageTrait
{
    /**
     * Minimum page number
     *
     * @var int
     */
    private static $pageMin = 1;

    /**
     * Maximum page number
     *
     * @var int
     */
    private static $pageMax = PHP_INT_MAX;

    /**
     * Validate page
     *
     * @param int    $value
     * @param string $message
     *
     * @return null
     * @throws \TxTextControl\ReportingCloud\Exception\InvalidArgumentException
     */
    public static function assertPage(int $value, string $message = '')
    {
        $format  = $message ?: 'Page number (%s) must be in the range [%2$s..%3$s]';
        $message = sprintf(
            $format,
            self::valueToString($value),
            self::valueToString(self::$pageMin),
            self::valueToString(self::$pageMax)
        );

        return self::range($value, self::$pageMin, self::$pageMax, $message);
    }
}
