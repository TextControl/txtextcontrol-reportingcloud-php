<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
    'test'     => true,
]);

// ---------------------------------------------------------------------------------------------------------------------

$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . DIRECTORY_SEPARATOR . 'test_document.docx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . DIRECTORY_SEPARATOR . 'test_document.pdf';

// ---------------------------------------------------------------------------------------------------------------------

$binaryData = $reportingCloud->convertDocument($sourceFilename, 'PDF');

if ($binaryData) {

    var_dump("{$sourceFilename} was converted");

    file_put_contents($destinationFilename, $binaryData);

    var_dump("And written to {$destinationFilename}");

} else {

    var_dump("Error converting {$sourceFilename}");
}

// ---------------------------------------------------------------------------------------------------------------------