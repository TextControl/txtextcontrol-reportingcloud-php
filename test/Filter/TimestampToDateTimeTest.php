<?php

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Filter\TimestampToDateTime as Filter;

class TimestampToDateTimeTest extends PHPUnit_Framework_TestCase
{
    protected $filter;

    public function setUp()
    {
        $this->filter = new Filter();
    }

    public function testDefault()
    {
        $this->assertEquals("2016-06-02T15:49:57", $this->filter->filter(1464882597));
    }

    public function testInvalid()
    {
        $this->assertNull($this->filter->filter('invalid'));
    }

}
