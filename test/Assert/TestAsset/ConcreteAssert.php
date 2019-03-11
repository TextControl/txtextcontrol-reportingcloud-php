<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Assert\TestAsset;

use TxTextControl\ReportingCloud\Assert\AbstractAssert;

/**
 * Class ConcreteAssert (for testing only)
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ConcreteAssert extends AbstractAssert
{
    /**
     * Convert value to string (public version for testing)
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function publicValueToString($value): string
    {
        return self::valueToString($value);
    }
}
