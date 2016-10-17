<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
    'test'     => true,
]);


$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . '/test_find_and_replace.tx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_find_and_replace.pdf';

$findAndReplaceData = [
    '%%FIELD1%%' => 'hello field 1',
    '%%FIELD2%%' => 'hello field 2',
];

$mergeSettings = [

    'creation_date'              => time(),
    'last_modification_date'     => time(),

    'remove_empty_blocks'        => true,
    'remove_empty_fields'        => true,
    'remove_empty_images'        => true,
    'remove_trailing_whitespace' => true,

    'author'                     => 'James Henry Trotter',
    'creator_application'        => 'The Giant Peach',
    'document_subject'           => 'The Old Green Grasshopper',
    'document_title'             => 'James and the Giant Peach',

    'user_password'              => '1',
];

$binaryData = $reportingCloud->findAndReplaceDocument($findAndReplaceData, 'PDF', null, $sourceFilename, $mergeSettings);

file_put_contents($destinationFilename, $binaryData);

var_dump($destinationFilename);