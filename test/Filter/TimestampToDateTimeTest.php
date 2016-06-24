<?php

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Filter\TimestampToDateTime as Filter;

class TimestampToDateTimeTest extends PHPUnit_Framework_TestCase
{
    protected $filter;

    protected $defaultTimezone;

    public function setUp()
    {
        $this->filter = new Filter();

        $this->defaultTimezone = date_default_timezone_get();
    }

    public function tearDown()
    {
        date_default_timezone_set($this->defaultTimezone);

        parent::tearDown();
    }

    /**
     * @dataProvider TxTextControlTest\ReportingCloud\Filter\TestAsset\DefaultProvider::defaultProvider
     */
    public function testValid($timeZone, $dateTimeString, $timestamp)
    {
        if (in_array($timeZone, timezone_identifiers_list())) {
            date_default_timezone_set($timeZone);
            $this->assertSame($dateTimeString, $this->filter->filter($timestamp));
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalid()
    {
        $this->filter->filter('invalid');
    }

}
