<?php

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Filter\DateTimeToTimestamp as Filter;

class DateTimeToTimestampTest extends PHPUnit_Framework_TestCase
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
     * @dataProvider defaultProvider
     */
    public function testDefault($timeZone, $dateTimeString, $timestamp)
    {
        date_default_timezone_set($timeZone);

        $this->assertEquals($timestamp, $this->filter->filter($dateTimeString));
    }

    public function defaultProvider()
    {
        return [
            ['UTC'          , '2016-06-02T15:49:57+00:00', 1464882597],
            ['UTC'          , '1970-01-01T00:00:00+00:00', 0],
            ['Europe/Berlin', '2016-06-02T15:49:57+00:00', 1464882597],
            ['Asia/Taipei'  , '2009-04-04T12:02:22+00:00', 1238846542],
            ['Europe/London', '2008-11-17T04:51:53+00:00', 1226897513],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotDateTimeStringInteger()
    {
        $this->filter->filter(123456789);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotDateTimeStringBoolean()
    {
        $this->filter->filter(true);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotDateTimeStringString()
    {
        $this->filter->filter('invalid');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotDateTimeInvalidOffset()
    {
        $this->filter->filter('2016-06-02T15:49:57+02:00');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotDateTimeStringTooLong()
    {
        $this->filter->filter('2016-06-06T13:05:05+00:00:00');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotDateTimeStringTooShort()
    {
        $this->filter->filter('2016-06-06T13:05:05');
    }

}
