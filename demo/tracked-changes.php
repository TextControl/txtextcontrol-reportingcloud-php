<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\FileUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

// Instantiate ReportingCloud, using your API key

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$sourceFilename      = sprintf('%s/tracked_changes.docx', Path::resource());
$destinationFilename = sprintf('%s/tracked_changes.docx', Path::output());

// Show all tracked changes in document

$results = $reportingCloud->getTrackedChanges($sourceFilename);

foreach ($results as $result) {

    foreach ($result as $key => $value) {
        ConsoleUtils::writeLn('%s: %s', $key, $value);
    }

    ConsoleUtils::writeLn('');

    switch ($result['change_kind']) {
        case ReportingCloud::TRACKED_CHANGE_DELETED_TEXT:
            $verb = 'deleted';
            break;
        case ReportingCloud::TRACKED_CHANGE_INSERTED_TEXT:
            $verb = 'inserted';
            break;
    }

    ConsoleUtils::writeLn('Text was %s ("%s").', $verb, $result['change_kind']);

    ConsoleUtils::writeLn('');
}

// Remove tracked change with ID 1

$result = $reportingCloud->removeTrackedChange($sourceFilename, 1, true);

if (isset($result['document'])) {
    FileUtils::write($destinationFilename, $result['document']);
    ConsoleUtils::writeLn('Written updated document to "%s".', $destinationFilename);
}
