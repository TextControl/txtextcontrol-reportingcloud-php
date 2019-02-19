<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$sourceFilename      = sprintf('%s/test_template.docx', constant('REPORTING_CLOUD_DEMO_MEDIA_PATH'));
$destinationFilename = sprintf('%s/test_template_merged.pdf', constant('REPORTING_CLOUD_DEMO_OUTPUT_PATH'));


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

dump($destinationFilename);
