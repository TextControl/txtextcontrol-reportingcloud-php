<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

// Instantiate ReportingCloud, using your API key

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

// Iterate over the account settings array, outputting the key-value pairs to the console

foreach ($reportingCloud->getAccountSettings() as $key => $value) {
    ConsoleUtils::writeLn('- %s: %s', $key, $value);
}
