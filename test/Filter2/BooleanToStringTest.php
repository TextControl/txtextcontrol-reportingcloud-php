<?php

namespace TxTextControlTest\ReportingCloud\Filter2;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\Filter2\Filter;

class BooleanToStringTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        unset($this->filter);
    }

    public function testDefault()
    {
        $this->assertSame('true', Filter::filterBooleanToString(true));
        $this->assertSame('false', Filter::filterBooleanToString(false));
    }
}
