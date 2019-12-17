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

namespace TxTextControlTest\ReportingCloud\Path;

use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControlTest\ReportingCloud\AbstractReportingCloudTest;

/**
 * Class ConsoleUtilsTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ConsoleUtilsTest extends AbstractReportingCloudTest
{
    public function testCheckCredentials(): void
    {
        $key = ConsoleUtils::API_KEY;

        $oldValue = getenv($key);

        putenv("${key}=");

        $this->assertFalse(ConsoleUtils::checkCredentials());

        putenv("${key}={$oldValue}");

        $this->assertTrue(ConsoleUtils::checkCredentials());
    }

    public function testApiKeyFromEnv(): void
    {
        $key   = ConsoleUtils::API_KEY;
        $value = 'xxxxxxxxxxxxxxxxxxxx';

        $oldValue = getenv($key);

        putenv("${key}={$value}");

        $this->assertEquals(ConsoleUtils::apiKey(), $value);

        putenv("${key}={$oldValue}");
    }

    public function testErrorMessage(): void
    {
        $errorMessage = ConsoleUtils::errorMessage();

        $this->assertStringContainsString(
            'Error: ReportingCloud API key not defined.',
            $errorMessage
        );

        $this->assertStringContainsString(
            'For further assistance and customer service please refer to:',
            $errorMessage
        );
    }

    public function testDump(): void
    {
        ob_start();
        ConsoleUtils::dump([1, 2, 3, 4, 5]);
        $actual = (string) ob_get_clean();

        $this->assertStringContainsString('array(5)', $actual);

        $this->assertStringContainsString('[0]', $actual);
        $this->assertStringContainsString('[1]', $actual);
        $this->assertStringContainsString('[2]', $actual);
        $this->assertStringContainsString('[3]', $actual);
        $this->assertStringContainsString('[4]', $actual);

        $this->assertStringContainsString('int(1)', $actual);
        $this->assertStringContainsString('int(2)', $actual);
        $this->assertStringContainsString('int(3)', $actual);
        $this->assertStringContainsString('int(4)', $actual);
        $this->assertStringContainsString('int(5)', $actual);
    }

    public function testWriteLineWith0Args(): void
    {
        $expected = '10 hello "world".' . PHP_EOL;

        ob_start();
        ConsoleUtils::writeLn('10 hello "world".');
        $actual = ob_get_clean();

        $this->assertEquals($expected, $actual);
    }

    public function testWriteLineWith1Arg(): void
    {
        $expected = '10 x hello.' . PHP_EOL;

        ob_start();
        ConsoleUtils::writeLn('%d x hello.', 10);
        $actual = ob_get_clean();

        $this->assertEquals($expected, $actual);
    }

    public function testWriteLineWith2Args(): void
    {
        $expected = '10 x hello "world".' . PHP_EOL;

        ob_start();
        ConsoleUtils::writeLn('%d x hello "%s".', 10, 'world');
        $actual = ob_get_clean();

        $this->assertEquals($expected, $actual);
    }
}
