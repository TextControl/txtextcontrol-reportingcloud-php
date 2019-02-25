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

$sourceFilename      = sprintf('%s/test_template.docx', Path::resource());
$destinationFilename = sprintf('%s/test_template_merged.pdf', Path::output());

$mergeData = [
    'name' => 'Jemima Puddle-Duck',
    'age'  => 7,
];

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    null,
    $sourceFilename
);

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);
