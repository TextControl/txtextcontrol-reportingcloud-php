<?php

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Filter\BooleanToString as Filter;

class BooleanToStringTest extends PHPUnit_Framework_TestCase
{
    protected $filter;

    public function setUp()
    {
        $this->filter = new Filter();
    }

    public function tearDown()
    {
        unset($this->filter);
    }

    public function testDefault()
    {
        $this->assertSame('true', $this->filter->filter(true));
        $this->assertSame('false', $this->filter->filter(false));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentExceptionOnInteger()
    {
        $this->filter->filter(1);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentExceptionOnNumberString()
    {
        $this->filter->filter('1');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentExceptionOnWordString()
    {
        $this->filter->filter('invalid');
    }
}
