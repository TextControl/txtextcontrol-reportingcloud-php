<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

// Instantiate ReportingCloud, using your API key

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

// Return an array of supported dictionaries

ConsoleUtils::dump(
    $reportingCloud->getAvailableDictionaries()
);

// Return an array spelling suggestions for a specific word

ConsoleUtils::dump(
    $reportingCloud->getProofingSuggestions(
        'ssky',
        'en_US.dic',
        10
    )
);

// Return an array of spelling issues

ConsoleUtils::dump(
    $reportingCloud->proofingCheck(
        'Thiss is a testt about rockkets in the ssky',
        'en_US.dic'
    )
);
