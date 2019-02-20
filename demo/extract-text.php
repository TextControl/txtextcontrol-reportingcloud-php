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

$sourceFilename      = sprintf('%s/camera_controls.pdf', $pathResource);
$destinationFilename = sprintf('%s/camera_controls.txt', $pathOutput);

$stringData = $reportingCloud->convertDocument($sourceFilename, 'TXT');

if (!empty($stringData)) {
    dump("{$sourceFilename} was converted");
    file_put_contents($destinationFilename, $stringData);
    dump("And written to {$destinationFilename}");
} else {
    dump("Error converting {$sourceFilename}");
}
