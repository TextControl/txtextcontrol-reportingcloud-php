<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

$imageFilename       = sprintf('%s/test_template_image.jpg', Path::resource());
$sourceFilename      = sprintf('%s/test_template_image.docx', Path::resource());
$destinationFilename = sprintf('%s/test_template_image_merged.pdf', Path::output());

$imageBinaryData = (string) file_get_contents($imageFilename);

// Base64 encode the image data before assigning to ReportingCloud.
// See: https://www.textcontrol.com/blog/2016/07/18/

$mergeData = [
    'title'  => 'Retro Speedometer from Classic Car',
    'source' => 'http://www.4freephotos.com/Retro-speedometer-from-classic-car-6342.html',
    'photo'  => base64_encode($imageBinaryData),
];

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    null,
    $sourceFilename
);

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

echo sprintf('Written to "%s".', $destinationFilename);
echo PHP_EOL;
