<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Stdlib;

use TxTextControlTest\ReportingCloud\AbstractReportingCloudTest;
use TxTextControl\ReportingCloud\Stdlib\StringUtils;

/**
 * Class StringUtilsTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class StringUtilsTest extends AbstractReportingCloudTest
{
    public function testStartsWith(): void
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

    public function testEndsWith(): void
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
