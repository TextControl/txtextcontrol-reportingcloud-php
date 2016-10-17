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

var_dump($reportingCloud->getTemplateInfo($templateName));

// ---------------------------------------------------------------------------------------------------------------------