<?php

include_once 'bootstrap.php';

use TXTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => reporting_cloud_username(),
    'password' => reporting_cloud_password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

$templateName   = 'test_template.tx';

$sourceFilename = REPORTING_CLOUD_DEMO_RESOURCE_PATH . DIRECTORY_SEPARATOR . $templateName;

// ---------------------------------------------------------------------------------------------------------------------

// Upload template, if not already in template storage

if (!$reportingCloud->templateExists($templateName)) {

    $reportingCloud->uploadTemplate($sourceFilename);
}

// ---------------------------------------------------------------------------------------------------------------------

// Write thumbnails (1 page per record in array)

$arrayOfBinaryData = $reportingCloud->getTemplateThumbnails($templateName, 400, 1, 1, 'PNG');

foreach ($arrayOfBinaryData as $index => $binaryData) {

    $destinationFile     = sprintf('test_template_p%d.png', $index);
    $destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . DIRECTORY_SEPARATOR . $destinationFile;

    file_put_contents($destinationFilename, $binaryData);

    dump("{$templateName} was written to {$destinationFilename}");
}

// ---------------------------------------------------------------------------------------------------------------------