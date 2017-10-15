<?php

/**
 * Available Cultures Resource File
 *
 * This script downloads all the available cultures from MSDN and writes them to the file:
 *
 *    resource/cultures.php
 *
 * The package maintainer should execute this script, whenever new cultures are added to the backend.
 *
 */

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Exception\RuntimeException;

$outputFilename = realpath(__DIR__ . '/../resource/cultures.php');

// ---------------------------------------------------------------------------------------------------------------------

$url      = 'https://msdn.microsoft.com/en-us/library/ee825488(v=cs.20).aspx';
$buffer   = file_get_contents($url);
$cultures = [];
if (preg_match_all('/<td data-th="Language Culture Name">(.*)<\/td>/U', $buffer, $matches) && isset($matches[1])) {
    $cultures = array_map('trim', $matches[1]);
    natsort($cultures);
    $cultures = array_values($cultures);
}

if (0 === count($cultures)) {
    throw new RuntimeException('Cannot download the available cultures from ' . $url);
}

// ---------------------------------------------------------------------------------------------------------------------

$buffer = '<?php';
$buffer .= PHP_EOL;
$buffer .= PHP_EOL;
$buffer .= 'return ';
$buffer .= var_export($cultures, true);
$buffer .= ';';
$buffer .= PHP_EOL;

file_put_contents($outputFilename, $buffer);

// ---------------------------------------------------------------------------------------------------------------------

echo PHP_EOL;
echo sprintf('The available cultures are %s.', implode(', ', $cultures));
echo PHP_EOL;
echo PHP_EOL;
echo sprintf('Written resource file to %s', $outputFilename);
echo PHP_EOL;
echo PHP_EOL;

// ---------------------------------------------------------------------------------------------------------------------