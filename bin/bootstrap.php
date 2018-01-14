<?php

use TxTextControl\ReportingCloud\Console\Helper;

$autoloadFilename = function () {

    // standard composer autoload file
    $file = 'autoload.php';

    $paths = [
        // when installed as a dependency to another project
        __DIR__ . '/../../..',
        // when installed as a GIT clone
        __DIR__ . '/../vendor',
    ];

    foreach ($paths as $path) {
        $filename = realpath($path . DIRECTORY_SEPARATOR . $file);
        if (is_readable($filename)) {
            return $filename;
        }
    }

    $message = sprintf(
        "Cannot load composer's %s. Tried %s. Did you run 'composer install'?",
        $file,
        implode(', ', $paths)
    );
    throw new RuntimeException($message);
};

include $autoloadFilename();

if (false === Helper::checkCredentials()) {
    echo Helper::errorMessage();
    die(1);
}

switch (basename(getcwd())) {
    case 'demo':
        $outputPath = dirname(__DIR__) . '/demo/output';
        if (!is_dir($outputPath)) {
            mkdir($outputPath);
        }
        define('REPORTING_CLOUD_DEMO_OUTPUT_PATH', $outputPath);
        define('REPORTING_CLOUD_DEMO_MEDIA_PATH', realpath(__DIR__ . '/../data'));
        break;
}
