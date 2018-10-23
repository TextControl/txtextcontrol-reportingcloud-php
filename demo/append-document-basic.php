<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'api_key' => Helper::apiKey(),
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

$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_append_document_basic.pdf';

$binaryData = $reportingCloud->appendDocument($documents, 'PDF');

file_put_contents($destinationFilename, $binaryData);

var_dump($destinationFilename);
