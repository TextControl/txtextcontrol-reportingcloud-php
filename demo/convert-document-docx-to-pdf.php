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
]);

// Specify the source (DOCX) and destination (PDF) filenames

$sourceFilename      = sprintf('%s/construction_turk.docx', Path::resource());
$destinationFilename = sprintf('%s/construction_turk.pdf', Path::output());

// Using ReportingCloud, convert the DOCX file to PDF file

$binaryData = $reportingCloud->convertDocument(
    $sourceFilename,
    ReportingCloud::FILE_FORMAT_PDF
);

// Write the document's binary data to disk

FileUtils::write($destinationFilename, $binaryData);

// Output to console the location of the generated document

ConsoleUtils::writeLn('"%s" was converted and written to "%s".', $sourceFilename, $destinationFilename);
