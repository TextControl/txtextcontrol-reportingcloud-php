<?php
declare(strict_types=1);

namespace TxTextControl\ReportingCloud;

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . '/test_template.docx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_template_merged.pdf';

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

$mergeData = [
    'name' => 'Jemima Puddle-Duck',
    'age'  => 7,
];

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    'PDF',
    null,
    $sourceFilename
);

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

var_dump($destinationFilename);
