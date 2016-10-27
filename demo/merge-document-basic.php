<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . '/test_template_basic.docx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_template_basic_merged.pdf';

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
    'test'     => true,
]);

$mergeData = [
    'name' => 'Jemima Puddle-Duck',
    'age'  => 7,
];

$arrayOfBinaryData = $reportingCloud->mergeDocument($mergeData, 'PDF', null, $sourceFilename);

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

var_dump($destinationFilename);