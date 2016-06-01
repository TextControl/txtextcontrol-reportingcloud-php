<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => reporting_cloud_username(),
    'password' => reporting_cloud_password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

dump($reportingCloud->getAccountSettings());

// ---------------------------------------------------------------------------------------------------------------------