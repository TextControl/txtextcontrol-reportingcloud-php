<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . '/test_document.docx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/test_document.pdf';

$binaryData = $reportingCloud->convertDocument($sourceFilename, 'PDF');

if (!empty($binaryData)) {
    var_dump("{$sourceFilename} was converted");
    file_put_contents($destinationFilename, $binaryData);
    var_dump("And written to {$destinationFilename}");
} else {
    var_dump("Error converting {$sourceFilename}");
}
