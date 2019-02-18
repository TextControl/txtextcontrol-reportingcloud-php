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

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

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
     * Maximum page number (PHP_INT_MAX)
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
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertPage(int $value, string $message = ''): void
    {
        $format  = $message ?: 'Page number ("%s") must be in the range [%d..%d]';
        $message = sprintf($format, $value, self::$pageMin, self::$pageMax);

        self::range($value, self::$pageMin, self::$pageMax, $message);
    }
}
