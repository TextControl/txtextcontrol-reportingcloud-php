<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Filter;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\Filter\Filter;

class BooleanToStringTest extends TestCase
{
    public function testTrueString()
    {
        $this->assertSame('true', Filter::filterBooleanToString(true));
    }

    public function testFalseString()
    {
        $this->assertSame('false', Filter::filterBooleanToString(false));
    }
}
