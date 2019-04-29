<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with API key via constructor option

$reportingCloud = new ReportingCloud([
    'api_key' => 'xxxxxxxx',
]);

ConsoleUtils::dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with API key and other params via constructor options

$reportingCloud = new ReportingCloud([
    'api_key'  => 'xxxxxxxx',
    'base_uri' => 'https://api.example.com',
    'debug'    => false,
    'test'     => false,
    'timeout'  => 100,
    'version'  => 'v1',
]);

ConsoleUtils::dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with API key via setter method

$reportingCloud = new ReportingCloud();

$reportingCloud->setApiKey('xxxxxxxx');

ConsoleUtils::dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with API key and other params via setter methods

$reportingCloud = new ReportingCloud();

$reportingCloud->setApiKey('xxxxxxxx');
$reportingCloud->setBaseUri('https://api.example.com');
$reportingCloud->setDebug(false);
$reportingCloud->setTest(false);
$reportingCloud->setTimeout(100);
$reportingCloud->setVersion('v1');

ConsoleUtils::dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------
