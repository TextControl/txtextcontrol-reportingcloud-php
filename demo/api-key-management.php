<?php
declare(strict_types=1);

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

// ---------------------------------------------------------------------------------------------------------------------

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$apiKeys = $reportingCloud->getApiKeys();

if (!empty($apiKeys)) {
    foreach ($apiKeys as $apiKey) {
        if ($apiKey['key'] == ConsoleUtils::apiKey()) {
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

