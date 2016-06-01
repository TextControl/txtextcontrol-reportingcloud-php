<?php

use TXTextControl\ReportingCloud\Exception\RuntimeException;

$filenameAutoload = realpath(__DIR__ . '/../vendor/autoload.php');

if (!is_readable($filenameAutoload)) {
    throw new RuntimeException("Cannot load composer's autoload.php file. Did you run composer install?");
}

include_once $filenameAutoload;

// ---------------------------------------------------------------------------------------------------------------------

$outputPath = __DIR__ . '/output';

if (!is_dir($outputPath)) {
    mkdir($outputPath);
}

define('REPORTING_CLOUD_DEMO_OUTPUT_PATH'  , $outputPath);
define('REPORTING_CLOUD_DEMO_RESOURCE_PATH', realpath(__DIR__ . '/../resource'));

// ---------------------------------------------------------------------------------------------------------------------