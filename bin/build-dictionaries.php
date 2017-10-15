<?php

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

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\ReportingCloud;

$outputFilename = realpath(__DIR__ . '/../resource/dictionaries.php');

// ---------------------------------------------------------------------------------------------------------------------

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);

$dictionaries = $reportingCloud->getAvailableDictionaries();

natsort($dictionaries);
$dictionaries = array_values($dictionaries);

if (0 === count($dictionaries)) {
    throw new RuntimeException('Cannot download the available dictionaries from the Reporting Cloud Web API.');
}

// ---------------------------------------------------------------------------------------------------------------------

$buffer = '<?php';
$buffer .= PHP_EOL;
$buffer .= PHP_EOL;
$buffer .= 'return ';
$buffer .= var_export($dictionaries, true);
$buffer .= ';';
$buffer .= PHP_EOL;

file_put_contents($outputFilename, $buffer);

// ---------------------------------------------------------------------------------------------------------------------

echo PHP_EOL;
echo sprintf('The available dictionaries are %s.', implode(', ', $dictionaries));
echo PHP_EOL;
echo PHP_EOL;
echo sprintf('Written resource file to %s', $outputFilename);
echo PHP_EOL;
echo PHP_EOL;

// ---------------------------------------------------------------------------------------------------------------------