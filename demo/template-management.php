<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

// ---------------------------------------------------------------------------------------------------------------------

$templateName = 'test_template.tx';

$sourceFilename      = sprintf('%s/%s', Path::resource(), $templateName);
$destinationFilename = sprintf('%s/%s', Path::output(), $templateName);

// ---------------------------------------------------------------------------------------------------------------------

// Check to see whether a template is in template storage
// Uploaded, if it is not

if (!$reportingCloud->templateExists($templateName)) {
    ConsoleUtils::writeLn('"%s" is not in template storage', $templateName);
    if ($reportingCloud->uploadTemplate($sourceFilename)) {
        ConsoleUtils::writeLn('Uploaded "%s".', $sourceFilename);
    } else {
        ConsoleUtils::writeLn('Error uploading "%s".', $sourceFilename);
    }
}

// ---------------------------------------------------------------------------------------------------------------------

// Get the number of pages in a template

$pageCount = $reportingCloud->getTemplatePageCount($templateName);

ConsoleUtils::writeLn('"%s" contains %d page%s.', $templateName, $pageCount, $pageCount > 1 ? 's' : '');

// ---------------------------------------------------------------------------------------------------------------------

// Download a template from template storage

$binaryData = $reportingCloud->downloadTemplate($templateName);

if ($binaryData) {
    ConsoleUtils::writeLn('"%s" was downloaded.', $templateName);
    file_put_contents($destinationFilename, $binaryData);
    ConsoleUtils::writeLn('"%s" was written to "%s".', $templateName, $destinationFilename);
} else {
    ConsoleUtils::writeLn('Error downloading "%s".', $templateName);
}

// ---------------------------------------------------------------------------------------------------------------------

// Count the number of templates in template storage

$templateCount = $reportingCloud->getTemplateCount();

ConsoleUtils::writeLn('There are %d template%s in template storage.', $templateCount, $templateCount > 1 ? 's' : '');

// ---------------------------------------------------------------------------------------------------------------------

// Get an array of all templates in template storage

ConsoleUtils::writeLn("They are as follows:");

foreach ($reportingCloud->getTemplateList() as $record) {

    $templateName      = $record['template_name'];
    $modifiedFormatted = date('r', $record['modified']);    // modified is a unix timestamp

    ConsoleUtils::writeLn('- %s', $templateName);
    ConsoleUtils::writeLn('- %s', $record['modified']);
    ConsoleUtils::writeLn('- %s', $modifiedFormatted);
}

// ---------------------------------------------------------------------------------------------------------------------

// Delete a template in template storage

if ($reportingCloud->deleteTemplate($templateName)) {
    ConsoleUtils::writeLn('"%s" was deleted.', $templateName);
} else {
    ConsoleUtils::writeLn('Error deleting "%s".', $templateName);
}

// ---------------------------------------------------------------------------------------------------------------------
