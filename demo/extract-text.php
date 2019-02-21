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

$sourceFilename      = sprintf('%s/camera_controls.pdf', Path::resource());
$destinationFilename = sprintf('%s/camera_controls.txt', Path::output());

$stringData = $reportingCloud->convertDocument($sourceFilename, 'TXT');

if (!empty($stringData)) {
    dump("{$sourceFilename} was converted");
    file_put_contents($destinationFilename, $stringData);
    dump("And written to {$destinationFilename}");
} else {
    dump("Error converting {$sourceFilename}");
}
