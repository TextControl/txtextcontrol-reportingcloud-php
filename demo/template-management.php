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

$sourceFilename      = sprintf('%s/%s', Path::resource(), $templateName);
$destinationFilename = sprintf('%s/%s', Path::output(), $templateName);

// ---------------------------------------------------------------------------------------------------------------------

// Check to see whether a template is in template storage
// Uploaded, if it is not

if (!$reportingCloud->templateExists($templateName)) {
    echo sprintf('"%s" is not in template storage', $templateName);
    echo PHP_EOL;
    if ($reportingCloud->uploadTemplate($sourceFilename)) {
        echo sprintf('Uploaded "%s".', $sourceFilename);
        echo PHP_EOL;
    } else {
        echo sprintf('Error uploading "%s".', $sourceFilename);
        echo PHP_EOL;
    }
}


// ---------------------------------------------------------------------------------------------------------------------

// Get the number of pages in a template

$pageCount = $reportingCloud->getTemplatePageCount($templateName);

echo sprintf('"%s" contains %d page%s.', $templateName, $pageCount, $pageCount > 1 ? 's' : '');
echo PHP_EOL;

// ---------------------------------------------------------------------------------------------------------------------

// Download a template from template storage

$binaryData = $reportingCloud->downloadTemplate($templateName);

if ($binaryData) {
    echo sprintf('"%s" was downloaded.', $templateName);
    echo PHP_EOL;
    file_put_contents($destinationFilename, $binaryData);
    echo sprintf('"%s" was written to "%s".', $templateName, $destinationFilename);
    echo PHP_EOL;
} else {
    echo sprintf('Error downloading "%s".', $templateName);
    echo PHP_EOL;
}

// ---------------------------------------------------------------------------------------------------------------------

// Count the number of templates in template storage

$templateCount = $reportingCloud->getTemplateCount();

echo sprintf('There are %d template%s in template storage.', $templateCount, $templateCount > 1 ? 's' : '');
echo PHP_EOL;

// ---------------------------------------------------------------------------------------------------------------------

// Get an array of all templates in template storage

echo "They are as follows:";
echo PHP_EOL;

foreach ($reportingCloud->getTemplateList() as $record) {

    $templateName      = $record['template_name'];
    $modifiedFormatted = date('r', $record['modified']);    // modified is a unix timestamp

    echo sprintf('- %s', $templateName);
    echo PHP_EOL;
    echo sprintf('- %s', $record['modified']);
    echo PHP_EOL;
    echo sprintf('- %s', $modifiedFormatted);
    echo PHP_EOL . PHP_EOL;
}

// ---------------------------------------------------------------------------------------------------------------------

// Delete a template in template storage

if ($reportingCloud->deleteTemplate($templateName)) {
    echo sprintf('"%s" was deleted.', $templateName);
    echo PHP_EOL;
} else {
    echo sprintf('Error deleting "%s".', $templateName);
    echo PHP_EOL;
}

// ---------------------------------------------------------------------------------------------------------------------
