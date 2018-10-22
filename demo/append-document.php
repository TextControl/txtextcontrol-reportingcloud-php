<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
    'test'     => true,
]);

$documents = [
    [
        'filename' => REPORTING_CLOUD_DEMO_MEDIA_PATH . '/test_document.docx',
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => REPORTING_CLOUD_DEMO_MEDIA_PATH . '/test_document.docx',
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => REPORTING_CLOUD_DEMO_MEDIA_PATH . '/test_document.docx',
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
];

$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_document_merge.pdf';

$documentSettings = [
    'author'                 => 'James Henry Trotter',
    'creation_date'          => time(),
    'creator_application'    => 'An awesome creator',
    'document_subject'       => 'The Old Green Grasshopper',
    'document_title'         => 'James and the Giant Peach',
    'last_modification_date' => time(),
    'user_password'          => '1',
];

$binaryData = $reportingCloud->appendDocument($documents, 'PDF', $documentSettings);

file_put_contents($destinationFilename, $binaryData);

var_dump($destinationFilename);
