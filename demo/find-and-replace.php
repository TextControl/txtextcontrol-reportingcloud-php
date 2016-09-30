<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\CliHelper as Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);

$findAndReplaceData = [
    [
        '%%FIELD1%%', 'hello field 1',
    ],
    [
        '%%FIELD2%%', 'hello field 2',
    ],
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

$binaryData = $reportingCloud->findAndReplace($findAndReplaceData, 'PDF', 'test_find_replace.tx', null, $mergeSettings);

$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_find_replace.pdf';

file_put_contents($destinationFilename, $binaryData);
