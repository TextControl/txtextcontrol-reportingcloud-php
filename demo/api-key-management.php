<?php
declare(strict_types=1);

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

// ---------------------------------------------------------------------------------------------------------------------

$reportingCloud = new ReportingCloud([
    'api_key' => Helper::apiKey(),
]);

$apiKeys = $reportingCloud->getApiKeys();

if (is_array($apiKeys)) {
    foreach ($apiKeys as $apiKey) {
        if ($apiKey['key'] == Helper::apiKey()) {
            echo sprintf("Keeping API key %s...\n", $apiKey['key']);
            continue;
        }
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

