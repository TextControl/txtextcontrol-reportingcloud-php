<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => reporting_cloud_username(),
    'password' => reporting_cloud_password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

$sourceFilename      = REPORTING_CLOUD_DEMO_RESOURCE_PATH . DIRECTORY_SEPARATOR . 'test_document.docx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH   . DIRECTORY_SEPARATOR . 'test_document.pdf';

// ---------------------------------------------------------------------------------------------------------------------

$binaryData = $reportingCloud->convertDocument($sourceFilename, 'PDF');

if ($binaryData) {

    dump("{$sourceFilename} was converted");

    file_put_contents($destinationFilename, $binaryData);

    dump("And written to {$destinationFilename}");

} else {

    dump("Error converting {$sourceFilename}");
}

// ---------------------------------------------------------------------------------------------------------------------