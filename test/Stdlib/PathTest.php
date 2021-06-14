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
 * @copyright © 2021 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Stdlib;

use TxTextControlTest\ReportingCloud\AbstractReportingCloudTest;
use TxTextControl\ReportingCloud\Stdlib\Path;

/**
 * Class PathTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class PathTest extends AbstractReportingCloudTest
{
    public function testRoot(): void
    {
        $expected = dirname(__FILE__, 3);
        $actual   = Path::root();
        self::assertEquals($expected, $actual);
    }

    public function testOthers(): void
    {
        $paths = [
            'bin',
            'data',
            'demo',
            'output',
            'resource',
            'test',
        ];

        foreach ($paths as $path) {
            $expected = sprintf('%s/%s', Path::root(), $path);
            // @phpstan-ignore-next-line
            $actual   = Path::$path();
            self::assertEquals($expected, $actual);
        }
    }
}
