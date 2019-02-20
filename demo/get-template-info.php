<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$pathResource = constant('TxTextControl\ReportingCloud\PATH_RESOURCE');

$templateNames = [
    'test_template.tx',
    'test_template_with_user_document_properties.docx',
];

foreach ($templateNames as $templateName) {

    $sourceFilename = sprintf('%s/%s', $pathResource, $templateName);

    if (!$reportingCloud->templateExists($templateName)) {
        $reportingCloud->uploadTemplate($sourceFilename);
    }

    dump($reportingCloud->getTemplateInfo($templateName));
}
