<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);


// ---------------------------------------------------------------------------------------------------------------------

var_dump($reportingCloud->getApiKeys());

// ---------------------------------------------------------------------------------------------------------------------

var_dump($reportingCloud->createApiKey());

// ---------------------------------------------------------------------------------------------------------------------

$apiKeys = $reportingCloud->getApiKeys();

foreach ($apiKeys as $apiKey) {

    var_dump($apiKey['key']);
    //var_dump($apiKey['active']);

    $reportingCloud->deleteApiKey($apiKey['key']);
}

// ---------------------------------------------------------------------------------------------------------------------
