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

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\Filter\Filter;

/**
 * Class DateTimeToTimestampTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class DateTimeToTimestampTest extends TestCase
{
    /**
     * @var string
     */
    protected string $defaultTimezone;

    public function setUp(): void
    {
        $this->defaultTimezone = date_default_timezone_get();
    }

    public function tearDown(): void
    {
        date_default_timezone_set($this->defaultTimezone);
    }

    /**
     * @param string $timeZone
     * @param string $dateTimeString
     * @param int    $timestamp
     *
     * @dataProvider \TxTextControlTest\ReportingCloud\Filter\TestAsset\DefaultProvider::defaultProvider
     */
    public function testValid(string $timeZone, string $dateTimeString, int $timestamp): void
    {
        $identifiers = timezone_identifiers_list();
        if (in_array($timeZone, $identifiers, true)) {
            date_default_timezone_set($timeZone);
            self::assertSame($timestamp, Filter::filterDateTimeToTimestamp($dateTimeString));
        }
    }
}
