<?php
declare(strict_types=1);

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'api_key' => Helper::apiKey(),
]);

// ---------------------------------------------------------------------------------------------------------------------

var_dump($reportingCloud->getFontList());

// ---------------------------------------------------------------------------------------------------------------------
