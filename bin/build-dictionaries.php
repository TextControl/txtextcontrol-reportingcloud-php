<?php
declare(strict_types=1);

/**
 * Available Dictionaries Resource File
 *
 * This script downloads all the available dictionaries from the Reporting Cloud Web API and writes them to the file:
 *
 *    resource/dictionaries.php
 *
 * The package maintainer should execute this script, whenever new dictionaries are added to the backend.
 *
 */

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\ReportingCloud;

// ---------------------------------------------------------------------------------------------------------------------

$filename = Assert::getLanguagesFilename();

$reportingCloud = new ReportingCloud([
    'api_key' => Helper::apiKey(),
]);

$values = $reportingCloud->getAvailableDictionaries();

if (0 === count($values)) {
    throw new RuntimeException('Cannot download the available dictionaries from the Reporting Cloud Web API.');
}

natcasesort($values);
$values = array_values($values);

// ---------------------------------------------------------------------------------------------------------------------

Helper::varExportToFile($filename, $values);

echo PHP_EOL;
echo sprintf('The available dictionaries (%d) are %s.', count($values), implode(', ', $values));
echo PHP_EOL;
echo PHP_EOL;
echo sprintf('Written resource file to %s', $filename);
echo PHP_EOL;
echo PHP_EOL;

// ---------------------------------------------------------------------------------------------------------------------
