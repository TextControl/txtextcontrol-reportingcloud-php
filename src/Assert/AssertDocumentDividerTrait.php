<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

use ReflectionClass;
use ReflectionException;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait DocumentDividerTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertDocumentDividerTrait
{
    public static function assertDocumentDivider(int $value, string $message = '')
    {
        $haystack = [];
        try {
            $reportingCloud  = new ReportingCloud();
            $reflectionClass = new ReflectionClass($reportingCloud);
            foreach ($reflectionClass->getConstants() as $constantKey => $constantValue) {
                if (0 === strpos($constantKey, 'DOCUMENT_DIVIDER_')) {
                    $haystack[] = $constantValue;
                }
            }
            unset($reportingCloud);
        } catch (ReflectionException $e) {
            $format  = 'Internal error validating %s';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        if (!in_array($value, $haystack)) {
            $format  = '%s contains an unsupported document divider';
            $message = sprintf($message ?: $format, static::valueToString($value));
            static::reportInvalidArgument($message);
        }

        return null;
    }
}
