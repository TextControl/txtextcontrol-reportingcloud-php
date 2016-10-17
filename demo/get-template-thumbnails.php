<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

$templateName   = 'test_template.tx';

$sourceFilename = REPORTING_CLOUD_DEMO_MEDIA_PATH . DIRECTORY_SEPARATOR . $templateName;

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

    var_dump("{$templateName} was written to {$destinationFilename}");
}

// ---------------------------------------------------------------------------------------------------------------------