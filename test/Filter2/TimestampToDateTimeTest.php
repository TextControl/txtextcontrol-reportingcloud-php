<?php

namespace TxTextControlTest\ReportingCloud\Filter2;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Filter2\Filter2;

class TimestampToDateTimeTest extends PHPUnit_Framework_TestCase
{
    protected $defaultTimezone;

    public function setUp()
    {
        $this->defaultTimezone = date_default_timezone_get();
    }

    public function tearDown()
    {
        date_default_timezone_set($this->defaultTimezone);

        parent::tearDown();
    }

    /**
     * @dataProvider TxTextControlTest\ReportingCloud\Filter2\TestAsset\DefaultProvider::defaultProvider
     */
    public function testValid($timeZone, $dateTimeString, $timestamp)
    {
        if (in_array($timeZone, timezone_identifiers_list())) {
            date_default_timezone_set($timeZone);
            $this->assertSame($dateTimeString, Filter2::filter2TimestampToDateTime($timestamp));
        }
    }
}
