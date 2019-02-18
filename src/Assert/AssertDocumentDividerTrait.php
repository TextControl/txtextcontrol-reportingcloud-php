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

use ReflectionClass;
use ReflectionException;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\StringUtils;

/**
 * Trait DocumentDividerTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertDocumentDividerTrait
{
    /**
     * @param mixed  $value
     * @param array  $values
     * @param string $message
     */
    abstract public static function oneOf($value, array $values, $message = '');

    /**
     * Validate a document divider
     *
     * @param int    $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertDocumentDivider(int $value, string $message = ''): void
    {
        $haystack = self::getDocumentDividers();
        $format   = $message ?: '"%d" contains an unsupported document divider';
        $message  = sprintf($format, $value);

        self::oneOf($value, $haystack, $message);
    }

    /**
     * Return document dividers array
     *
     * @return array
     */
    private static function getDocumentDividers(): array
    {
        $constants = [];

        try {
            $reportingCloud  = new ReportingCloud();
            $reflectionClass = new ReflectionClass($reportingCloud);
            $constants       = $reflectionClass->getConstants();
            unset($reportingCloud);
        } catch (ReflectionException $e) {
            // continue
        }

        $ret = array_filter($constants, function (string $constantKey): bool {
            if (StringUtils::startsWith($constantKey, 'DOCUMENT_DIVIDER_')) {
                return true;
            }
            return false;
        }, ARRAY_FILTER_USE_KEY);

        $ret = array_values($ret);

        return $ret;
    }
}
