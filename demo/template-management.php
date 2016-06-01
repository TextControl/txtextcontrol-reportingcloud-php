<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => reporting_cloud_username(),
    'password' => reporting_cloud_password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

$templateName        = 'test_template.tx';

$sourceFilename      = REPORTING_CLOUD_DEMO_RESOURCE_PATH . DIRECTORY_SEPARATOR . $templateName;
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH   . DIRECTORY_SEPARATOR . $templateName;

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