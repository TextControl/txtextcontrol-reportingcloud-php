<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

// Instantiate ReportingCloud, using your API key

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$sourceFilename      = sprintf('%s/maelzel_machine.docx', Path::resource());
$destinationFilename = sprintf('%s/maelzel_machine.pdf', Path::output());

$document = $reportingCloud->convertDocument(
    $sourceFilename,
    ReportingCloud::FILE_FORMAT_PDF
);

if (empty($document)) {
    ConsoleUtils::writeLn('Error converting "%s".', $sourceFilename);
} else {
    file_put_contents($destinationFilename, $document);
    ConsoleUtils::writeLn('"%s" was converted and written to "%s".', $sourceFilename, $destinationFilename);
}
