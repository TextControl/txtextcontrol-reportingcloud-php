<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$imageFilename       = REPORTING_CLOUD_DEMO_MEDIA_PATH  . '/test_template_image.jpg';
$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . '/test_template_image.docx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_template_image_merged.pdf';

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

$imageBinaryData = file_get_contents($imageFilename);

// Base64 encode the image data before assigning to ReportingCloud.
// See: https://www.textcontrol.com/blog/2016/07/18/

$mergeData = [
    'title'  => 'Retro Speedometer from Classic Car',
    'source' => 'http://www.4freephotos.com/Retro-speedometer-from-classic-car-6342.html',
    'photo'  => base64_encode($imageBinaryData),
];

$arrayOfBinaryData = $reportingCloud->mergeDocument($mergeData, 'PDF', null, $sourceFilename);

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

var_dump($destinationFilename);
