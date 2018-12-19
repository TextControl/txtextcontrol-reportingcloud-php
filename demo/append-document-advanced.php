<?php
declare(strict_types=1);

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
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

$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_append_document_advanced.pdf';

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
