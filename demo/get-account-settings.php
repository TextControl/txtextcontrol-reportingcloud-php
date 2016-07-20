<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\CliHelper as Helper;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

var_dump($reportingCloud->getAccountSettings());

// ---------------------------------------------------------------------------------------------------------------------