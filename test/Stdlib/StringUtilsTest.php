<?php

namespace TxTextControlTest\ReportingCloud\Stdlib;

use PHPUnit\Framework\TestCase;
use TxTextControl\ReportingCloud\Stdlib\StringUtils;

class StringUtilsTest extends TestCase
{
    public function testStartsWith()
    {
        $haystack = 'Chad is an energetic former personal trainer';

        $this->assertTrue(StringUtils::startsWith($haystack, 'C'));
        $this->assertTrue(StringUtils::startsWith($haystack, 'Ch'));
        $this->assertTrue(StringUtils::startsWith($haystack, 'Cha'));
        $this->assertTrue(StringUtils::startsWith($haystack, 'Chad'));
        $this->assertTrue(StringUtils::startsWith($haystack, 'Chad is'));

        $haystack = 'He has a post-graduate degree in sports science';

        $this->assertFalse(StringUtils::startsWith($haystack, 'has'));
    }

    public function testEndsWith()
    {
        $haystack = 'Ariella is 20 years older than him and works as a journalist';

        $this->assertTrue(StringUtils::endsWith($haystack, 't'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'st'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'ist'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'list'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'alist'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'nalist'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'rnalist'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'urnalist'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'ournalist'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'journalist'));
        $this->assertTrue(StringUtils::endsWith($haystack, 'a journalist'));

        $haystack = 'He grew up in a middle class neighbourhood';

        $this->assertFalse(StringUtils::endsWith($haystack, 'class'));
    }
}
