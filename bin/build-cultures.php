<?php

/**
 * Available Cultures Resource File
 *
 * According to
 *
 *    https://www.textcontrol.com/blog/2017/10/13/
 *
 * ReportingCloud uses the culture values as defined at
 *
 *   https://msdn.microsoft.com/en-us/library/ee825488(v=cs.20).aspx
 *
 * This script downloads these culture values and writes them to the file:
 *
 *    resource/cultures.php
 *
 * The package maintainer should execute this script, whenever new cultures are added to the backend.
 *
 */

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\Validator\Culture as Validator;

$validator = new Validator();

// ---------------------------------------------------------------------------------------------------------------------

$url    = 'https://msdn.microsoft.com/en-us/library/ee825488(v=cs.20).aspx';
$buffer = file_get_contents($url);
$values = [];

$pattern = '/<td data-th="Language Culture Name">(.*)<\/td>/U';
if (preg_match_all($pattern, $buffer, $matches) && isset($matches[1])) {
    $values = array_map('trim', $matches[1]);
}

if (0 === count($values)) {
    throw new RuntimeException('Cannot download the available cultures from ' . $url);
}

natcasesort($values);
$values = array_values($values);

// ---------------------------------------------------------------------------------------------------------------------

var_export_file($validator->getFilename(), $values);

echo PHP_EOL;
echo sprintf('The available cultures (%d) are %s.', count($values), implode(', ', $values));
echo PHP_EOL;
echo PHP_EOL;
echo sprintf('Written resource file to %s', $validator->getFilename());
echo PHP_EOL;
echo PHP_EOL;

// ---------------------------------------------------------------------------------------------------------------------
