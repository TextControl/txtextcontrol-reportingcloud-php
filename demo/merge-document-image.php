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

// Specify the source image (JPG) and template (DOCX) and destination (PDF) filenames

$imageFilename       = sprintf('%s/test_template_image.jpg', Path::resource());
$sourceFilename      = sprintf('%s/test_template_image.docx', Path::resource());
$destinationFilename = sprintf('%s/test_template_image_merged.pdf', Path::output());

// Load the image data from disk, base64 encoding them before assigning to ReportingCloud.
// See: https://www.textcontrol.com/blog/2016/07/18/

$imageBinaryData              = (string) file_get_contents($imageFilename);
$imageBinaryDataBase64Encoded = base64_encode($imageBinaryData);

// Specify array of merge data

$mergeData = [
    'title'  => 'Retro Speedometer from Classic Car',
    'source' => 'http://www.4freephotos.com/Retro-speedometer-from-classic-car-6342.html',
    'photo'  => $imageBinaryDataBase64Encoded
];

// Using ReportingCloud, merge the image data into the template and return binary data

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    '',
    $sourceFilename
);

// Write the document's binary data to disk

FileUtils::write($destinationFilename, $arrayOfBinaryData[0]);

// Output to console the location of the generated document

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);
