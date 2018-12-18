<?php

namespace TxTextControlTest\ReportingCloud\Stdlib;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\Stdlib\Stdlib;

class StdlibTest extends TestCase
{
    public function testStartsWith()
    {
        $haystack = 'Chad is an energetic former personal trainer';

        $this->assertTrue(Stdlib::startsWith($haystack, 'C'));
        $this->assertTrue(Stdlib::startsWith($haystack, 'Ch'));
        $this->assertTrue(Stdlib::startsWith($haystack, 'Cha'));
        $this->assertTrue(Stdlib::startsWith($haystack, 'Chad'));
        $this->assertTrue(Stdlib::startsWith($haystack, 'Chad is'));

        $haystack = 'He has a post-graduate degree in sports science';

        $this->assertFalse(Stdlib::startsWith($haystack, 'has'));
    }

    public function testEndsWith()
    {
        $haystack = 'Ariella is 20 years older than him and works as a journalist';

        $this->assertTrue(Stdlib::endsWith($haystack, 't'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'st'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'ist'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'list'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'alist'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'nalist'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'rnalist'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'urnalist'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'ournalist'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'journalist'));
        $this->assertTrue(Stdlib::endsWith($haystack, 'a journalist'));

        $haystack = 'He grew up in a middle class neighbourhood';

        $this->assertFalse(Stdlib::endsWith($haystack, 'class'));
    }
}
