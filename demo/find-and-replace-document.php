<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
    'test'    => true,
]);

$sourceFilename      = REPORTING_CLOUD_DEMO_MEDIA_PATH  . DIRECTORY_SEPARATOR . 'test_find_and_replace.tx';
$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . DIRECTORY_SEPARATOR . 'test_find_and_replace.pdf';

$findAndReplaceData = [
    '%%FIELD1%%' => 'hello field 1',
    '%%FIELD2%%' => 'hello field 2',
];

$mergeSettings = [
    'author'                     => 'James Henry Trotter',
    'creation_date'              => time(),
    'creator_application'        => 'The Giant Peach',
    'document_subject'           => 'The Old Green Grasshopper',
    'document_title'             => 'James and the Giant Peach',
    'last_modification_date'     => time(),
    'merge_html'                 => false,
    'remove_empty_blocks'        => true,
    'remove_empty_fields'        => true,
    'remove_empty_images'        => true,
    'remove_trailing_whitespace' => true,
    'user_password'              => '1',
];

$binaryData = $reportingCloud->findAndReplaceDocument(
    $findAndReplaceData,
    'PDF',
    null,
    $sourceFilename,
    $mergeSettings
);

file_put_contents($destinationFilename, $binaryData);

var_dump($destinationFilename);
