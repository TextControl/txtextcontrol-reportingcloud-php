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

    /** @dataProvider defaultProvider */
    public function testDefault($timezone, $datetime, $timestamp)
    {
        date_default_timezone_set($timezone);
        $this->assertEquals($datetime, $this->filter->filter($timestamp));
    }

    public function defaultProvider()
    {
        return [
            ['Europe/Berlin', '2016-06-02T15:49:57', 1464882597],
            ['UTC', '2016-06-02T15:49:57', 1464882597],
            ['UTC', '1972-10-12T15:50:00', 87753000],
            ['UTC', '2011-08-01T11:15:08', 1312197308],
            ['UTC', '1997-06-19T17:03:48', 866739828],
            ['UTC', '2016-03-04T04:39:29', 1457066369],
            ['UTC', '2004-12-09T19:03:14', 1102618994],
            ['UTC', '2016-05-27T00:09:08', 1464307748],
            ['UTC', '1978-11-09T05:26:14', 279437174],
            ['UTC', '1976-12-27T11:12:07', 220533127],
            ['UTC', '1981-09-09T09:47:30', 368876850],
            ['UTC', '2007-12-01T20:12:01', 1196539921],
            ['UTC', '1976-02-02T06:10:16', 192089416],
            ['UTC', '1984-03-16T12:15:05', 448287305],
            ['UTC', '1992-11-27T22:44:59', 722904299],
            ['UTC', '1970-03-28T00:22:37', 7431757],
            ['UTC', '1971-02-03T00:48:56', 34390136],
            ['UTC', '2015-04-14T20:16:21', 1429042581],
            ['UTC', '1985-05-21T16:43:27', 485541807],
            ['UTC', '1985-09-10T16:02:03', 495216123],
            ['UTC', '2013-04-12T02:15:17', 1365732917],
            ['UTC', '1993-10-15T19:15:47', 750712547],
            ['UTC', '2005-05-08T17:43:01', 1115574181],
            ['UTC', '2001-01-06T09:01:10', 978771670],
            ['UTC', '2006-05-28T14:55:37', 1148828137],
            ['UTC', '1991-01-22T10:50:46', 664541446],
            ['UTC', '1992-10-22T17:31:13', 719775073],
            ['UTC', '1971-02-27T13:27:22', 36509242],
            ['UTC', '1991-07-15T23:49:33', 679621773],
            ['UTC', '1972-01-27T18:47:41', 65386061],
            ['UTC', '2015-11-29T16:33:38', 1448814818],
            ['UTC', '1987-04-25T21:15:28', 546383728],
            ['UTC', '1972-02-25T11:41:33', 67866093],
            ['UTC', '1972-04-08T02:57:20', 71549840],
            ['UTC', '1982-06-22T03:04:18', 393563058],
            ['UTC', '1999-08-14T04:45:20', 934605920],
            ['UTC', '1972-01-07T02:10:30', 63598230],
            ['UTC', '1970-12-27T16:41:13', 31164073],
            ['UTC', '1999-08-05T23:28:10', 933895690],
            ['UTC', '1980-11-14T07:36:44', 343035404],
            ['UTC', '1977-12-23T03:53:19', 251697199],
            ['UTC', '2011-04-14T09:15:40', 1302772540],
            ['UTC', '1972-05-12T22:22:27', 74557347],
            ['UTC', '1984-01-24T10:03:35', 443786615],
            ['UTC', '1979-01-24T16:04:27', 286041867],
            ['UTC', '1995-04-09T21:07:26', 797461646],
            ['UTC', '1984-04-19T10:26:12', 451218372],
            ['UTC', '1980-02-26T16:53:22', 320432002],
            ['UTC', '1994-02-17T11:57:29', 761486249],
            ['UTC', '1999-09-08T03:09:39', 936760179],
            ['UTC', '1995-11-06T08:55:25', 815648125],
            ['UTC', '1970-01-01T00:00:00', 0],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOutOfRange()
    {
        $this->filter->filter(-5000);
    }

}
