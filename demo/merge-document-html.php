<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . '/test_template.docx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_template_html_merged.pdf';

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
    'test'     => true,
]);

// mergeFields containing HTML must be contained in an <html /> tag.
// Additionally, merge_html must be set to true in the merge settings array

$mergeData = [
    'name' => '<html><i>Jemima</i> <strong>Puddle-Duck</strong></html>',
    'age'  => 7,
];

$mergeSettings = [
    'merge_html' => true,
];

$arrayOfBinaryData = $reportingCloud->mergeDocument($mergeData, 'PDF', null, $sourceFilename, null, $mergeSettings);

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

var_dump($destinationFilename);