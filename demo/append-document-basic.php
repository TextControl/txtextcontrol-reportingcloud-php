<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$documents = [
    [
        'filename' => sprintf('%s/test_document.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/test_document.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/test_document.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
];

$destinationFilename = sprintf('%s/test_append_document_basic.pdf', Path::output());

$binaryData = $reportingCloud->appendDocument(
    $documents,
    ReportingCloud::FILE_FORMAT_PDF
);

file_put_contents($destinationFilename, $binaryData);

echo sprintf('Written to "%s".', $destinationFilename);
echo PHP_EOL;
