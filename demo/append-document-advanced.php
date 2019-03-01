<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

// Instantiate ReportingCloud, using your API key

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

$documents = [
    [
        'filename' => sprintf('%s/maelzel_machine.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/maelzel_machine.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/maelzel_machine.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
];

$destinationFilename = sprintf('%s/test_append_document_advanced.pdf', Path::output());

$documentSettings = [
    'author'                 => 'Wikipedia',
    'creation_date'          => time(),
    'creator_application'    => 'ReportingCloud PHP SDK',
    'document_subject'       => 'The Mechanical Turk',
    'document_title'         => 'Mälzel and the Machine',
    'last_modification_date' => time(),
    'user_password'          => '1',
];

$binaryData = $reportingCloud->appendDocument(
    $documents,
    ReportingCloud::FILE_FORMAT_PDF,
    $documentSettings
);

file_put_contents($destinationFilename, $binaryData);

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);
