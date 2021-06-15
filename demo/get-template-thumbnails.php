<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\FileUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

// Instantiate ReportingCloud, using your API key

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

// Specify the template name

$templateName = 'test_template.tx';

// Specify the source filename

$sourceFilename = sprintf('%s/%s', Path::resource(), $templateName);

// Upload template, if not already in template storage

if (!$reportingCloud->templateExists($templateName)) {
    $reportingCloud->uploadTemplate($sourceFilename);
}

// Using ReportingCloud, generate a thumbnail of each page in the template

$arrayOfBinaryData = $reportingCloud->getTemplateThumbnails(
    $templateName,
    400,
    1,
    1,
    ReportingCloud::FILE_FORMAT_PNG
);

// Iterate over returned binary PNG data (1 image per record in array)

foreach ($arrayOfBinaryData as $index => $binaryData) {

    // Specify page number (index is 0-based)

    $page = $index + 1;

    // Specify destination file and filenames

    $destinationFile     = sprintf('test_template_p%d.png', $page);
    $destinationFilename = sprintf('%s/%s', Path::output(), $destinationFile);

    // Write the thumbnail's binary data to disk

    FileUtils::write($destinationFilename, $binaryData);

    // Output to console the location of the image file

    ConsoleUtils::writeLn('"%s" was written to "%s".', $templateName, $destinationFilename);
}
