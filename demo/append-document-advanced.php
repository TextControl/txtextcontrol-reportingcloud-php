<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\FileUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

// Instantiate with API key via constructor options

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

// Create an array of document filenames and seperators that should be between the documents

$documents = [
    [
        'filename' => sprintf('%s/construction_turk.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/maelzel_machine.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
    [
        'filename' => sprintf('%s/maelzel_america.docx', Path::resource()),
        'divider'  => ReportingCloud::DOCUMENT_DIVIDER_NEW_SECTION,
    ],
];

// Specify the output filename

$destinationFilename = sprintf('%s/test_append_document_advanced.pdf', Path::output());

// Create an array of PDF document properties

$documentSettings = [
    'author'                 => 'Wikipedia',
    'creation_date'          => time(),
    'creator_application'    => 'ReportingCloud PHP SDK',
    'document_subject'       => 'The Mechanical Turk',
    'document_title'         => 'Mälzel and the Machine',
    'last_modification_date' => time(),
    'user_password'          => '1', // NOTE: You need to enter this password when opening the PDF file
];

// Using ReportingCloud, create a new PDF document, containing the above files and PDF document properties

$binaryData = $reportingCloud->appendDocument(
    $documents,
    ReportingCloud::FILE_FORMAT_PDF,
    $documentSettings
);

// Write the document's binary data to disk

FileUtils::write($destinationFilename, $binaryData);

// Output to console the location of the generated document

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);
