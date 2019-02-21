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

$sourceFilename = sprintf('%s/%s', Path::resource(), $templateName);

// ---------------------------------------------------------------------------------------------------------------------

// Upload template, if not already in template storage

if (!$reportingCloud->templateExists($templateName)) {

    $reportingCloud->uploadTemplate($sourceFilename);
}

// ---------------------------------------------------------------------------------------------------------------------

// Write thumbnails (1 page per record in array)

$arrayOfBinaryData = $reportingCloud->getTemplateThumbnails(
    $templateName,
    400,
    1,
    1,
    ReportingCloud::FILE_FORMAT_PNG
);

foreach ($arrayOfBinaryData as $index => $binaryData) {

    $destinationFile     = sprintf('test_template_p%d.png', $index);
    $destinationFilename = sprintf('%s/%s', Path::output(), $destinationFile);

    file_put_contents($destinationFilename, $binaryData);

    echo sprintf('"%s" was written to "%s".', $templateName, $destinationFilename);
    echo PHP_EOL;
}

// ---------------------------------------------------------------------------------------------------------------------
