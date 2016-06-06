<?php

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
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
        $this->assertEquals('1972-10-12T15:50:00', $this->filter->filter(87753000));
        $this->assertEquals('2011-08-01T11:15:08', $this->filter->filter(1312197308));
        $this->assertEquals('1997-06-19T17:03:48', $this->filter->filter(866739828));
        $this->assertEquals('2016-03-04T04:39:29', $this->filter->filter(1457066369));
        $this->assertEquals('2004-12-09T19:03:14', $this->filter->filter(1102618994));
        $this->assertEquals('2016-05-27T00:09:08', $this->filter->filter(1464307748));
        $this->assertEquals('1978-11-09T05:26:14', $this->filter->filter(279437174));
        $this->assertEquals('1976-12-27T11:12:07', $this->filter->filter(220533127));
        $this->assertEquals('1981-09-09T09:47:30', $this->filter->filter(368876850));
        $this->assertEquals('2007-12-01T20:12:01', $this->filter->filter(1196539921));
        $this->assertEquals('1976-02-02T06:10:16', $this->filter->filter(192089416));
        $this->assertEquals('1984-03-16T12:15:05', $this->filter->filter(448287305));
        $this->assertEquals('1992-11-27T22:44:59', $this->filter->filter(722904299));
        $this->assertEquals('1970-03-28T00:22:37', $this->filter->filter(7431757));
        $this->assertEquals('1971-02-03T00:48:56', $this->filter->filter(34390136));
        $this->assertEquals('2015-04-14T20:16:21', $this->filter->filter(1429042581));
        $this->assertEquals('1985-05-21T16:43:27', $this->filter->filter(485541807));
        $this->assertEquals('1985-09-10T16:02:03', $this->filter->filter(495216123));
        $this->assertEquals('2013-04-12T02:15:17', $this->filter->filter(1365732917));
        $this->assertEquals('1993-10-15T19:15:47', $this->filter->filter(750712547));
        $this->assertEquals('2005-05-08T17:43:01', $this->filter->filter(1115574181));
        $this->assertEquals('2001-01-06T09:01:10', $this->filter->filter(978771670));
        $this->assertEquals('2006-05-28T14:55:37', $this->filter->filter(1148828137));
        $this->assertEquals('1991-01-22T10:50:46', $this->filter->filter(664541446));
        $this->assertEquals('1992-10-22T17:31:13', $this->filter->filter(719775073));
        $this->assertEquals('1971-02-27T13:27:22', $this->filter->filter(36509242));
        $this->assertEquals('1991-07-15T23:49:33', $this->filter->filter(679621773));
        $this->assertEquals('1972-01-27T18:47:41', $this->filter->filter(65386061));
        $this->assertEquals('2015-11-29T16:33:38', $this->filter->filter(1448814818));
        $this->assertEquals('1987-04-25T21:15:28', $this->filter->filter(546383728));
        $this->assertEquals('1972-02-25T11:41:33', $this->filter->filter(67866093));
        $this->assertEquals('1972-04-08T02:57:20', $this->filter->filter(71549840));
        $this->assertEquals('1982-06-22T03:04:18', $this->filter->filter(393563058));
        $this->assertEquals('1999-08-14T04:45:20', $this->filter->filter(934605920));
        $this->assertEquals('1972-01-07T02:10:30', $this->filter->filter(63598230));
        $this->assertEquals('1970-12-27T16:41:13', $this->filter->filter(31164073));
        $this->assertEquals('1999-08-05T23:28:10', $this->filter->filter(933895690));
        $this->assertEquals('1980-11-14T07:36:44', $this->filter->filter(343035404));
        $this->assertEquals('1977-12-23T03:53:19', $this->filter->filter(251697199));
        $this->assertEquals('2011-04-14T09:15:40', $this->filter->filter(1302772540));
        $this->assertEquals('1972-05-12T22:22:27', $this->filter->filter(74557347));
        $this->assertEquals('1984-01-24T10:03:35', $this->filter->filter(443786615));
        $this->assertEquals('1979-01-24T16:04:27', $this->filter->filter(286041867));
        $this->assertEquals('1995-04-09T21:07:26', $this->filter->filter(797461646));
        $this->assertEquals('1984-04-19T10:26:12', $this->filter->filter(451218372));
        $this->assertEquals('1980-02-26T16:53:22', $this->filter->filter(320432002));
        $this->assertEquals('1994-02-17T11:57:29', $this->filter->filter(761486249));
        $this->assertEquals('1999-09-08T03:09:39', $this->filter->filter(936760179));
        $this->assertEquals('1995-11-06T08:55:25', $this->filter->filter(815648125));
        $this->assertEquals('1970-01-01T00:00:00', $this->filter->filter(0));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOutOfRange()
    {
        $this->filter->filter(-5000);
    }

}
