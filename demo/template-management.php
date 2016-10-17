<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

$templateName        = 'test_template.tx';

$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . DIRECTORY_SEPARATOR . $templateName;
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . DIRECTORY_SEPARATOR . $templateName;

// ---------------------------------------------------------------------------------------------------------------------

// Check to see whether a template is in template storage
// Uploaded, if it is not

if (!$reportingCloud->templateExists($templateName)) {

    var_dump("{$templateName} is not in template storage");

    if ($reportingCloud->uploadTemplate($sourceFilename)) {

        var_dump("Uploaded {$sourceFilename}");

    } else {

        var_dump("Error uploading {$sourceFilename}");
    }
}

// ---------------------------------------------------------------------------------------------------------------------

// Get the number of pages in a template

$pageCount = $reportingCloud->getTemplatePageCount($templateName);

var_dump("{$templateName} contains {$pageCount} page(s)");

// ---------------------------------------------------------------------------------------------------------------------

// Download a template from template storage

$binaryData = $reportingCloud->downloadTemplate($templateName);

if ($binaryData) {

    var_dump("{$templateName} was downloaded");

    file_put_contents($destinationFilename, $binaryData);

    var_dump("{$templateName} was written to {$destinationFilename}");

} else {

    var_dump("Error downloading {$templateName}");
}

// ---------------------------------------------------------------------------------------------------------------------

// Count the number of templates in template storage

$templateCount = $reportingCloud->getTemplateCount();

var_dump("There are {$templateCount} template(s) in template storage.");

// ---------------------------------------------------------------------------------------------------------------------

// Get an array of all templates in template storage

var_dump("They are as follows:");

foreach ($reportingCloud->getTemplateList() as $record) {

    $templateName      = $record['template_name'];
    $modifiedFormatted = date('r', $record['modified']);    // modified is a unix timestamp

    var_dump("- {$templateName}");
    var_dump("- {$record['modified']}");
    var_dump("- {$modifiedFormatted}");
}

// ---------------------------------------------------------------------------------------------------------------------

// Delete a template in template storage

if ($reportingCloud->deleteTemplate($templateName)) {

    var_dump("{$templateName} was deleted");

} else {

    var_dump("Error deleting {$templateName}");
}

// ---------------------------------------------------------------------------------------------------------------------
