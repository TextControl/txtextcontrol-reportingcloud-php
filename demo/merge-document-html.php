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

// Specify the source (DOCX) and destination (PDF) filenames

$sourceFilename      = sprintf('%s/test_template.docx', Path::resource());
$destinationFilename = sprintf('%s/test_template_html_merged.pdf', Path::output());

// Specify array of merge data, containing HTML. Note that merge fields containing
// HTML must be contained in an <html /> tag.
// See: https://www.textcontrol.com/blog/2017/08/21/

$mergeData = [
    'name' => '<html><i>Johann</i> <strong>Nepomuk Mälzel</strong></html>',
    'age'  => 41,
];

// Since we are merging HTML data, merge_html must be set to true
// See: https://www.textcontrol.com/blog/2017/08/21/

$mergeSettings = [
    'merge_html' => true,
];

// Using ReportingCloud, merge the HTML merge data into the template and return binary data

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    null,
    $sourceFilename,
    null,
    $mergeSettings
);

// Write the document's binary data to disk

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

// Output to console the location of the generated document

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);
