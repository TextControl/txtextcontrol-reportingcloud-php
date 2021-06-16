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

/**
 * Trait AssertTemplateNameTrait
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait AssertTemplateNameTrait
{
    use ValueToStringTrait;
    use AssertTemplateFormatTrait;

    /**
     * Check value is a valid template name
     *
     * @param string $value
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function assertTemplateName(string $value, string $message = ''): void
    {
        if (basename($value) != $value) {
            $format  = 0 === strlen($message) ? '%1$s contains path information (\'/\', \'.\', or \'..\')' : $message;
            $message = sprintf($format, self::valueToString($value));
            throw new InvalidArgumentException($message);
        }

        $extension = pathinfo($value, PATHINFO_EXTENSION);

        try {
            self::assertTemplateFormat(/** @scrutinizer ignore-type */ $extension);
        } catch (InvalidArgumentException $e) {
            $format  = 0 === strlen($message) ? '%1$s contains an unsupported file extension' : $message;
            $message = sprintf($format, self::valueToString($value));
            throw new InvalidArgumentException($message);
        }
    }
}
