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
    dump("{$templateName} is not in template storage");
    if ($reportingCloud->uploadTemplate($sourceFilename)) {
        dump("Uploaded {$sourceFilename}");
    } else {
        dump("Error uploading {$sourceFilename}");
    }
}

// ---------------------------------------------------------------------------------------------------------------------

// Get the number of pages in a template

$pageCount = $reportingCloud->getTemplatePageCount($templateName);

dump("{$templateName} contains {$pageCount} page(s)");

// ---------------------------------------------------------------------------------------------------------------------

// Download a template from template storage

$binaryData = $reportingCloud->downloadTemplate($templateName);

if ($binaryData) {
    dump("{$templateName} was downloaded");
    file_put_contents($destinationFilename, $binaryData);
    dump("{$templateName} was written to {$destinationFilename}");
} else {
    dump("Error downloading {$templateName}");
}

// ---------------------------------------------------------------------------------------------------------------------

// Count the number of templates in template storage

$templateCount = $reportingCloud->getTemplateCount();

dump("There are {$templateCount} template(s) in template storage.");

// ---------------------------------------------------------------------------------------------------------------------

// Get an array of all templates in template storage

dump("They are as follows:");

foreach ($reportingCloud->getTemplateList() as $record) {

    $templateName      = $record['template_name'];
    $modifiedFormatted = date('r', $record['modified']);    // modified is a unix timestamp

    dump("- {$templateName}");
    dump("- {$record['modified']}");
    dump("- {$modifiedFormatted}");
}

// ---------------------------------------------------------------------------------------------------------------------

// Delete a template in template storage

if ($reportingCloud->deleteTemplate($templateName)) {
    dump("{$templateName} was deleted");
} else {
    dump("Error deleting {$templateName}");
}

// ---------------------------------------------------------------------------------------------------------------------
