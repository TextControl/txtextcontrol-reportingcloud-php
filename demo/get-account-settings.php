<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

foreach ($reportingCloud->getAccountSettings() as $key => $value) {
    ConsoleUtils::writeLn('- %s: %s', $key, $value);
}
