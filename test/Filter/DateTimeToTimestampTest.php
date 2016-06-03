<?php

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Filter\DateTimeToTimestamp as Filter;

class DateTimeToTimestampTest extends PHPUnit_Framework_TestCase
{
    protected $filter;

    public function setUp()
    {
        $this->filter = new Filter();
    }

    public function testDefault()
    {
        $this->assertEquals(1464882597, $this->filter->filter("2016-06-02T15:49:57"));
    }

    public function testInvalid()
    {
        $this->assertNull($this->filter->filter(-5000));
    }

}
