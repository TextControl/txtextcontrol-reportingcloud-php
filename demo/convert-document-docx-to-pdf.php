<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$sourceFilename      = sprintf('%s/test_document.docx', Path::resource());
$destinationFilename = sprintf('%s/test_document.pdf', Path::output());

$document = $reportingCloud->convertDocument(
    $sourceFilename,
    ReportingCloud::FILE_FORMAT_PDF
);

if (empty($document)) {
    echo sprintf('Error converting "%s".', $sourceFilename);
    echo PHP_EOL;
} else {
    file_put_contents($destinationFilename, $document);
    echo sprintf('"%s" was converted and written to "%s".', $sourceFilename, $destinationFilename);
    echo PHP_EOL;
}
