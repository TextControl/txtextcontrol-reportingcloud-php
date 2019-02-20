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
$destinationFilename = sprintf('%s/test_template_html_merged.pdf', $pathOutput);

// mergeFields containing HTML must be contained in an <html /> tag.
// Additionally, merge_html must be set to true in the merge settings array
// See: https://www.textcontrol.com/blog/2017/08/21/

$mergeData = [
    'name' => '<html><i>Jemima</i> <strong>Puddle-Duck</strong></html>',
    'age'  => 7,
];

$mergeSettings = [
    'merge_html' => true,
];

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    'PDF',
    null,
    $sourceFilename,
    null,
    $mergeSettings
);

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

dump($destinationFilename);
