<?php
declare(strict_types=1);

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

var_dump($reportingCloud->getAvailableDictionaries());

var_dump($reportingCloud->getProofingSuggestions('ssky', 'en_US.dic', 10));

var_dump($reportingCloud->proofingCheck('Thiss is a testt about rockkets in the ssky', 'en_US.dic'));
