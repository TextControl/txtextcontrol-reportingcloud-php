<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

$pathResource = constant('TxTextControl\ReportingCloud\PATH_RESOURCE');
$pathOutput   = constant('TxTextControl\ReportingCloud\PATH_OUTPUT');

$sourceFilename      = sprintf('%s/test_template.docx', $pathResource);
$destinationFilename = sprintf('%s/test_template_merged.pdf', $pathOutput);

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
