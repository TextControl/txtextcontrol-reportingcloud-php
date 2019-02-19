<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$documents = [
    [
        'filename' => sprintf('%s/test_document.docx', constant('REPORTING_CLOUD_DEMO_MEDIA_PATH')),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/test_document.docx', constant('REPORTING_CLOUD_DEMO_MEDIA_PATH')),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/test_document.docx', constant('REPORTING_CLOUD_DEMO_MEDIA_PATH')),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
];

$destinationFilename = sprintf('%s/test_append_document_basic.pdf', constant('REPORTING_CLOUD_DEMO_OUTPUT_PATH'));

$binaryData = $reportingCloud->appendDocument($documents, 'PDF');

file_put_contents($destinationFilename, $binaryData);

dump($destinationFilename);
