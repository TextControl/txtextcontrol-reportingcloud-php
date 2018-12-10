<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud\Assert;

/**
 * Trait AssertTemplateExtensionTrait
 *
 * @package TxTextControl\ReportingCloud\Assert
 */
trait AssertTemplateExtensionTrait
{
    /**
     * Validate template extension
     *
     * @param string $value
     * @param string $message
     *
     * @return null
     */
    public static function assertTemplateExtension(string $value, string $message = '')
    {
        return self::assertTemplateFormat($value, $message);
    }
}
