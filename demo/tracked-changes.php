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

    assert(is_array($result));

    foreach ($result as $key => $value) {
        ConsoleUtils::writeLn('%s: %s', $key, $value);
    }

    ConsoleUtils::writeLn();

    switch ($result['change_kind']) {
        case ReportingCloud::TRACKED_CHANGE_DELETED_TEXT:
            $word = 'deleted';
            break;
        case ReportingCloud::TRACKED_CHANGE_INSERTED_TEXT:
            $word = 'inserted';
            break;
        default:
            $word = '';
            break;
    }

    ConsoleUtils::writeLn('Change kind was "%s" ("%s").', $word, $result['change_kind']);

    switch ($result['highlight_mode']) {
        case ReportingCloud::HIGHLIGHT_MODE_NEVER:
            $word = 'never';
            break;
        case ReportingCloud::HIGHLIGHT_MODE_ACTIVATED:
            $word = 'activated';
            break;
        case ReportingCloud::HIGHLIGHT_MODE_ALWAYS:
            $word = 'always';
            break;
        default:
            $word = '';
            break;
    }

    ConsoleUtils::writeLn('Highlight mode was "%s" ("%s").', $word, $result['highlight_mode']);

    ConsoleUtils::writeLn();
}

// Remove tracked change with ID 1

$result = $reportingCloud->removeTrackedChange($sourceFilename, 1, true);

if (isset($result['document']) && is_string($result['document'])) {
    FileUtils::write($destinationFilename, $result['document']);
    ConsoleUtils::writeLn('Written updated document to "%s".', $destinationFilename);
}
