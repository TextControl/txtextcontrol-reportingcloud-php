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
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Assert;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\StringUtils;

/**
 * Trait AssertBaseUriTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertBaseUriTrait
{
    /**
     * @param mixed $value
     *
     * @return string
     */
    abstract protected static function valueToString($value): string;

    /**
     * Check value is a known base URI
     *
     * @param mixed  $value
     * @param string $message
     */
    public static function assertBaseUri($value, string $message = ''): void
    {
        $baseUri = ReportingCloud::DEFAULT_BASE_URI;

        $host1 = parse_url($baseUri, PHP_URL_HOST);
        $host2 = (string) parse_url($value, PHP_URL_HOST);

        if (!StringUtils::endsWith($host2, $host1)) {
            $format  = 0 === strlen($message) ? 'Expected base URI to end in %2$s. Got %1$s' : $message;
            $message = sprintf($format, self::valueToString($value), self::valueToString($host1));
            throw new InvalidArgumentException($message);
        }
    }
}
