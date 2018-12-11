<?php
declare(strict_types=1);

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'api_key' => Helper::apiKey(),
]);

// ---------------------------------------------------------------------------------------------------------------------

$templateNames = [
    'test_template.tx',
    'test_template_with_user_document_properties.docx',
];

foreach ($templateNames as $templateName) {

    $sourceFilename = REPORTING_CLOUD_DEMO_MEDIA_PATH . DIRECTORY_SEPARATOR . $templateName;

    if (!$reportingCloud->templateExists($templateName)) {
        $reportingCloud->uploadTemplate($sourceFilename);
    }

    var_dump($reportingCloud->getTemplateInfo($templateName));
}

// ---------------------------------------------------------------------------------------------------------------------
