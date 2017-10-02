<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\ReportingCloud;

$outputFilename = realpath(__DIR__ . '/../resource/available-dictionaries.php');

// ---------------------------------------------------------------------------------------------------------------------

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
]);

$availableDictionaries = $reportingCloud->getAvailableDictionaries();

sort($availableDictionaries);

if (0 === count($availableDictionaries)) {
    throw new RuntimeException('Cannot download the available dictionaries from the Reporting Cloud Web API.');
}

// ---------------------------------------------------------------------------------------------------------------------

$buffer = '<?php';
$buffer .= PHP_EOL;
$buffer .= PHP_EOL;
$buffer .= 'return ';
$buffer .= var_export($availableDictionaries, true);
$buffer .= ';';
$buffer .= PHP_EOL;

file_put_contents($outputFilename, $buffer);

// ---------------------------------------------------------------------------------------------------------------------

echo PHP_EOL;
echo 'The available dictionaries are:';
echo PHP_EOL;

foreach ($availableDictionaries as $availableDictionary) {
    echo sprintf('- %s', $availableDictionary);
    echo PHP_EOL;
}

echo PHP_EOL;
echo sprintf('Written available dictionaries to %s', $outputFilename);
echo PHP_EOL;
echo PHP_EOL;

// ---------------------------------------------------------------------------------------------------------------------