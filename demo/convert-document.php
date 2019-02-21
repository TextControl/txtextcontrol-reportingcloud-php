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

$sourceFilename      = sprintf('%s/test_document.docx', Path::resource());
$destinationFilename = sprintf('%s/test_document.pdf', Path::output());

$binaryData = $reportingCloud->convertDocument($sourceFilename, 'PDF');

if (!empty($binaryData)) {
    dump("{$sourceFilename} was converted");
    file_put_contents($destinationFilename, $binaryData);
    dump("And written to {$destinationFilename}");
} else {
    dump("Error converting {$sourceFilename}");
}
