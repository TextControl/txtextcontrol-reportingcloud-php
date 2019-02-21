<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

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
            echo sprintf("Keeping API key %s...", $apiKey['key']);
            echo PHP_EOL;
            continue;
        }
        echo sprintf("Deleting API key %s...", $apiKey['key']);
        echo PHP_EOL;
        $reportingCloud->deleteApiKey($apiKey['key']);
        unset($apiKey);
    }
}

$newApiKey = $reportingCloud->createApiKey();

unset($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

$reportingCloud = new ReportingCloud([
    'api_key' => $newApiKey,
]);

dump($reportingCloud->getAccountSettings());
dump($reportingCloud->getTemplateList());

// ---------------------------------------------------------------------------------------------------------------------
