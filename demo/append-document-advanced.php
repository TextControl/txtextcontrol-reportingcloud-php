<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$pathResource = constant('TxTextControl\ReportingCloud\PATH_RESOURCE');
$pathOutput   = constant('TxTextControl\ReportingCloud\PATH_OUTPUT');

$documents = [
    [
        'filename' => sprintf('%s/test_document.docx', $pathResource),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/test_document.docx', $pathResource),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/test_document.docx', $pathResource),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
];

$destinationFilename = sprintf('%s/test_append_document_advanced.pdf', $pathOutput);

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

dump($destinationFilename);
