<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

//var_dump($reportingCloud->getAvailableDictionaries());

// ---------------------------------------------------------------------------------------------------------------------

var_dump($reportingCloud->getProofingSuggestions('ssky', 'en_US.dic', 10));

// ---------------------------------------------------------------------------------------------------------------------

//var_dump($reportingCloud->spellCheck('Thiss is a testt about rockkets in the ssky', 'en_US.dic'));

// ---------------------------------------------------------------------------------------------------------------------
