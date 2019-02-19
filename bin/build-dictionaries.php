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

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\Assert\Assert;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ArrayUtils;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

// ---------------------------------------------------------------------------------------------------------------------

$filename = Assert::getDictionariesFilename();

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

$values = $reportingCloud->getAvailableDictionaries();

if (0 === count($values)) {
    $message = 'Cannot download the available dictionaries from the Reporting Cloud Web API.';
    throw new RuntimeException($message);
}

natcasesort($values);
$values = array_values($values);

// ---------------------------------------------------------------------------------------------------------------------

$search    = dirname(__FILE__, 2);
$replace   = '';
$generator = str_replace($search, $replace, __FILE__);

ArrayUtils::varExportToFile($filename, $values, $generator);

echo PHP_EOL;
echo sprintf('The available dictionaries (%d) are %s.', count($values), implode(', ', $values));
echo PHP_EOL;
echo PHP_EOL;
echo sprintf('Written data file to %s', $filename);
echo PHP_EOL;
echo PHP_EOL;

// ---------------------------------------------------------------------------------------------------------------------
