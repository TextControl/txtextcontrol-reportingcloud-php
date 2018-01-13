<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with username and password via constructor options

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
    'base_uri' => 'http://api.example.com',
    'timeout'  => 100,
    'version'  => 'v1',
    'debug'    => true,
]);

var_dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with username and password via setter methods

$reportingCloud = new ReportingCloud();

$reportingCloud->setUsername(Helper::username());
$reportingCloud->setPassword(Helper::password());
$reportingCloud->setBaseUri('http://api.example.com');
$reportingCloud->setVersion('v1');
$reportingCloud->setTimeout(100);
$reportingCloud->getDebug(true);

var_dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with API key via constructor option

$apiKey = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

$reportingCloud = new ReportingCloud([
    'api_key' => $apiKey,
]);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with API key via setter method

$apiKey = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

$reportingCloud = new ReportingCloud();

$reportingCloud->setApiKey($apiKey);

// ---------------------------------------------------------------------------------------------------------------------
