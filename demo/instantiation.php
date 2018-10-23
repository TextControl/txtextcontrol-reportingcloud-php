<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

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

// Instantiate with username and password via constructor options
// @deprecated: Use the API key method instead (see above)

$reportingCloud = new ReportingCloud([
    'username' => 'xxxxxxxx',
    'password' => 'xxxxxxxx',
    'base_uri' => 'http://api.example.com',
    'timeout'  => 100,
    'version'  => 'v1',
    'debug'    => true,
]);

var_dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate with username and password via setter methods
// @deprecated: Use the API key method instead (see above)

$reportingCloud = new ReportingCloud();

$reportingCloud->setUsername('xxxxxxxx');
$reportingCloud->setPassword('xxxxxxxx');
$reportingCloud->setBaseUri('http://api.example.com');
$reportingCloud->setVersion('v1');
$reportingCloud->setTimeout(100);
$reportingCloud->getDebug(true);

var_dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------
