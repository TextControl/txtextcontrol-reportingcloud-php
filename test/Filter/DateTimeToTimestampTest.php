<?php

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
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
        $this->assertEquals(685431539,  $this->filter->filter('1991-09-21T05:38:59'));
        $this->assertEquals(1456954200, $this->filter->filter('2016-03-02T21:30:00'));
        $this->assertEquals(635899288,  $this->filter->filter('1990-02-24T22:41:28'));
        $this->assertEquals(649366715,  $this->filter->filter('1990-07-30T19:38:35'));
        $this->assertEquals(5748313,    $this->filter->filter('1970-03-08T12:45:13'));
        $this->assertEquals(817934028,  $this->filter->filter('1995-12-02T19:53:48'));
        $this->assertEquals(45876855,   $this->filter->filter('1971-06-15T23:34:15'));
        $this->assertEquals(160579014,  $this->filter->filter('1975-02-02T13:16:54'));
        $this->assertEquals(629337306,  $this->filter->filter('1989-12-10T23:55:06'));
        $this->assertEquals(249683354,  $this->filter->filter('1977-11-29T20:29:14'));
        $this->assertEquals(118212340,  $this->filter->filter('1973-09-30T04:45:40'));
        $this->assertEquals(1441792051, $this->filter->filter('2015-09-09T09:47:31'));
        $this->assertEquals(487553515,  $this->filter->filter('1985-06-13T23:31:55'));
        $this->assertEquals(901837811,  $this->filter->filter('1998-07-30T22:30:11'));
        $this->assertEquals(301700008,  $this->filter->filter('1979-07-24T21:33:28'));
        $this->assertEquals(459508113,  $this->filter->filter('1984-07-24T09:08:33'));
        $this->assertEquals(459914029,  $this->filter->filter('1984-07-29T01:53:49'));
        $this->assertEquals(1331022551, $this->filter->filter('2012-03-06T08:29:11'));
        $this->assertEquals(628073482,  $this->filter->filter('1989-11-26T08:51:22'));
        $this->assertEquals(1080281100, $this->filter->filter('2004-03-26T06:05:00'));
        $this->assertEquals(800521958,  $this->filter->filter('1995-05-15T07:12:38'));
        $this->assertEquals(714206234,  $this->filter->filter('1992-08-19T06:37:14'));
        $this->assertEquals(981854794,  $this->filter->filter('2001-02-11T01:26:34'));
        $this->assertEquals(1286683509, $this->filter->filter('2010-10-10T04:05:09'));
        $this->assertEquals(203664077,  $this->filter->filter('1976-06-15T05:21:17'));
        $this->assertEquals(392912719,  $this->filter->filter('1982-06-14T14:25:19'));
        $this->assertEquals(1311458999, $this->filter->filter('2011-07-23T22:09:59'));
        $this->assertEquals(442916997,  $this->filter->filter('1984-01-14T08:29:57'));
        $this->assertEquals(1121576074, $this->filter->filter('2005-07-17T04:54:34'));
        $this->assertEquals(762097629,  $this->filter->filter('1994-02-24T13:47:09'));
        $this->assertEquals(132413682,  $this->filter->filter('1974-03-13T13:34:42'));
        $this->assertEquals(341989899,  $this->filter->filter('1980-11-02T05:11:39'));
        $this->assertEquals(754034117,  $this->filter->filter('1993-11-23T05:55:17'));
        $this->assertEquals(768312970,  $this->filter->filter('1994-05-07T12:16:10'));
        $this->assertEquals(991356614,  $this->filter->filter('2001-06-01T00:50:14'));
        $this->assertEquals(759782429,  $this->filter->filter('1994-01-28T18:40:29'));
        $this->assertEquals(121229284,  $this->filter->filter('1973-11-04T02:48:04'));
        $this->assertEquals(1037233469, $this->filter->filter('2002-11-14T00:24:29'));
        $this->assertEquals(920361442,  $this->filter->filter('1999-03-02T07:57:22'));
        $this->assertEquals(750566590,  $this->filter->filter('1993-10-14T02:43:10'));
        $this->assertEquals(1286916823, $this->filter->filter('2010-10-12T20:53:43'));
        $this->assertEquals(1038573783, $this->filter->filter('2002-11-29T12:43:03'));
        $this->assertEquals(727340928,  $this->filter->filter('1993-01-18T07:08:48'));
        $this->assertEquals(309452625,  $this->filter->filter('1979-10-22T15:03:45'));
        $this->assertEquals(475393880,  $this->filter->filter('1985-01-24T05:51:20'));
        $this->assertEquals(1029040935, $this->filter->filter('2002-08-11T04:42:15'));
        $this->assertEquals(768960737,  $this->filter->filter('1994-05-15T00:12:17'));
        $this->assertEquals(935307910,  $this->filter->filter('1999-08-22T07:45:10'));
        $this->assertEquals(895045772,  $this->filter->filter('1998-05-13T07:49:32'));
        $this->assertEquals(1397034219, $this->filter->filter('2014-04-09T09:03:39'));
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
    public function testDateTimeStringWithTimeZoneWithColon()
    {
        $this->filter->filter('1972-05-12T22:22:27+00:00');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testDateTimeStringWithTimeZoneWithoutColon()
    {
        $this->filter->filter('1972-05-12T22:22:27+0000');
    }
    
}
