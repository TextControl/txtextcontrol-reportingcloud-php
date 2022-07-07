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

/**
 * Trait AssertPageTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertPageTrait
{
    use ValueToStringTrait;
    use AssertRangeTrait;

    /**
     * Minimum page number
     *
     * @var int
     */
    private static int $pageMin = 1;

    /**
     * Maximum page number (PHP_INT_MAX)
     *
     * @var int
     */
    private static int $pageMax = PHP_INT_MAX;

    /**
     * Check value is a valid page number
     *
     * @param int    $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertPage(int $value, string $message = ''): void
    {
        $format  = 0 === strlen($message) ? 'Page number (%1$s) must be in the range [%2$s..%3$s]' : $message;
        $message = sprintf(
            $format,
            self::valueToString($value),
            self::valueToString(self::$pageMin),
            self::valueToString(self::$pageMax)
        );

        self::assertRange($value, self::$pageMin, self::$pageMax, $message);
    }
}
