<?php

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\Filter\Filter;

class BooleanToStringTest extends TestCase
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
