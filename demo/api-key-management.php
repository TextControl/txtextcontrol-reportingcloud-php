<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

// ---------------------------------------------------------------------------------------------------------------------

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);

$apiKeys = $reportingCloud->getApiKeys();

if (is_array($apiKeys)) {
    foreach ($apiKeys as $apiKey) {
        echo sprintf("Deleting API key %s...\n", $apiKey['key']);
        $reportingCloud->deleteApiKey($apiKey['key']);
        unset($apiKey);
    }
}

$apiKey = $reportingCloud->createApiKey();

unset($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

$reportingCloud = new ReportingCloud([
    'api_key' => $apiKey,
]);

dump($reportingCloud->getAccountSettings());
dump($reportingCloud->getTemplateList());

// ---------------------------------------------------------------------------------------------------------------------

