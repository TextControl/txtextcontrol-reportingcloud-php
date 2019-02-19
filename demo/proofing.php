<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

dump($reportingCloud->getAvailableDictionaries());

dump($reportingCloud->getProofingSuggestions('ssky', 'en_US.dic', 10));

dump($reportingCloud->proofingCheck('Thiss is a testt about rockkets in the ssky', 'en_US.dic'));
