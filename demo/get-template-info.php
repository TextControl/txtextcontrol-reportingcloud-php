<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

// Instantiate with API key via constructor options

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

// Specify template for which information should be returned

$templateNames = [
    'test_template.tx',
    'test_template_with_user_document_properties.docx',
];

// If the template is not already in ReportingCloud, upload it,
// then dump all available information about the template

foreach ($templateNames as $templateName) {

    $sourceFilename = sprintf('%s/%s', Path::resource(), $templateName);

    if (!$reportingCloud->templateExists($templateName)) {
        $reportingCloud->uploadTemplate($sourceFilename);
    }

    ConsoleUtils::dump($reportingCloud->getTemplateInfo($templateName));
}
