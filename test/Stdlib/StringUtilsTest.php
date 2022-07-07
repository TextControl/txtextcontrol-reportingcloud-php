<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2022 Text Control GmbH
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

        self::assertTrue(StringUtils::startsWith($haystack, 'C'));
        self::assertTrue(StringUtils::startsWith($haystack, 'Ch'));
        self::assertTrue(StringUtils::startsWith($haystack, 'Cha'));
        self::assertTrue(StringUtils::startsWith($haystack, 'Chad'));
        self::assertTrue(StringUtils::startsWith($haystack, 'Chad is'));

        $haystack = 'He has a post-graduate degree in sports science';

        self::assertFalse(StringUtils::startsWith($haystack, 'has'));
    }

    public function testEndsWith(): void
    {
        $haystack = 'Ariella is 20 years older than him and works as a journalist';

        self::assertTrue(StringUtils::endsWith($haystack, 't'));
        self::assertTrue(StringUtils::endsWith($haystack, 'st'));
        self::assertTrue(StringUtils::endsWith($haystack, 'ist'));
        self::assertTrue(StringUtils::endsWith($haystack, 'list'));
        self::assertTrue(StringUtils::endsWith($haystack, 'alist'));
        self::assertTrue(StringUtils::endsWith($haystack, 'nalist'));
        self::assertTrue(StringUtils::endsWith($haystack, 'rnalist'));
        self::assertTrue(StringUtils::endsWith($haystack, 'urnalist'));
        self::assertTrue(StringUtils::endsWith($haystack, 'ournalist'));
        self::assertTrue(StringUtils::endsWith($haystack, 'journalist'));
        self::assertTrue(StringUtils::endsWith($haystack, 'a journalist'));

        $haystack = 'He grew up in a middle class neighbourhood';

        self::assertFalse(StringUtils::endsWith($haystack, 'class'));
    }
}
