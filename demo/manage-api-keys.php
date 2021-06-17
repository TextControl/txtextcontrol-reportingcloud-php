<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

// Instantiate with API key via constructor options

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

// Loop through all API keys, deleting each one, except for the one you are currently using

foreach ($reportingCloud->getApiKeys() as $apiKey) {
    assert(isset($apiKey['key']));
    assert(is_string($apiKey['key']));
    if ($apiKey['key'] === $reportingCloud->getApiKey()) {
        ConsoleUtils::writeLn('Keeping API key "%s" (in use).', $apiKey['key']);
        continue;
    }
    ConsoleUtils::writeLn('Deleting API key "%s".', $apiKey['key']);
    $reportingCloud->deleteApiKey($apiKey['key']);
}

// Create a new API key

$newApiKey = $reportingCloud->createApiKey();

// Destroy the ReportingCloud instance

unset($reportingCloud);

// Instantiate with API key via constructor options again, using the new API key created above

$reportingCloud = new ReportingCloud([
    'api_key' => $newApiKey,
]);

// Call 2 endpoints to prove the new API key is working

ConsoleUtils::dump($reportingCloud->getAccountSettings());

ConsoleUtils::dump($reportingCloud->getTemplateList());
