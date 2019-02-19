<?php
declare(strict_types=1);

use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

/**
 * This file bootstraps all console scripts:
 *
 * - test
 * - demo
 * - bin
 *
 */

/**
 * @return string
 * @throws RuntimeException;
 */
$autoloadFilename = function (): string {

    // standard composer autoload file
    $file = 'autoload.php';

    $paths = [
        // when installed as a dependency to another project
        __DIR__ . '/../..',
        // when installed as a GIT clone
        __DIR__ . '/vendor',
    ];

    foreach ($paths as $path) {
        $filename = $path . DIRECTORY_SEPARATOR . $file;
        if (is_readable($filename)) {
            return (string) realpath($filename);
        }
    }

    $format  = "Cannot load composer's %s. Tried %s. Did you run 'composer install'?";
    $message = sprintf($format, $file, implode(', ', $paths));
    throw new RuntimeException($message);
};

/**
 * @psalm-suppress UnresolvableInclude
 */
include $autoloadFilename();

if (!ConsoleUtils::checkCredentials()) {
    echo ConsoleUtils::errorMessage();
    die(1);
}

switch (basename(getcwd())) {
    case 'demo':
        $outputPath = __DIR__ . '/demo/output';
        if (!is_dir($outputPath)) {
            mkdir($outputPath);
        }
        define('REPORTING_CLOUD_DEMO_OUTPUT_PATH', $outputPath);
        define('REPORTING_CLOUD_DEMO_MEDIA_PATH', __DIR__ . '/resource');
        break;
}
