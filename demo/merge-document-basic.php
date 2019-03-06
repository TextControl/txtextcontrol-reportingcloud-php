<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\FileUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

// Instantiate ReportingCloud, using your API key

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

// Specify the source (DOCX) and destination (PDF) filenames

$sourceFilename      = sprintf('%s/test_template.docx', Path::resource());
$destinationFilename = sprintf('%s/test_template_merged.pdf', Path::output());

// Specify array of merge data

$mergeData = [
    'name' => 'Johann Nepomuk Mälzel',
    'age'  => 41,
];

// Using ReportingCloud, insert the merge data into the template and return binary data

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    null,
    $sourceFilename
);

// Write the document's binary data to disk

FileUtils::write($destinationFilename, $arrayOfBinaryData[0]);

// Output to console the location of the generated document

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);
