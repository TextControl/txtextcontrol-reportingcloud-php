<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Return an ArrayObject FileInfos which should be executed
 *
 * @return ArrayObject
 *
 */
$getDemos = function (): ArrayObject {

    $arrayObject = new ArrayObject();
    $iterator    = new DirectoryIterator(__DIR__);

    $extensions = [
        'php',
    ];

    $skipFiles = [
        basename(__FILE__),
        'bootstrap.php',
        'init.php',
    ];

    foreach ($iterator as $fileInfo) {
        if (!in_array($fileInfo->getExtension(), $extensions, true)) {
            continue;
        }
        if (in_array($fileInfo->getFilename(), $skipFiles, true)) {
            continue;
        }
        $index = $fileInfo->getFilename();
        $value = clone $fileInfo;
        $arrayObject->offsetSet($index, $value);
    }

    $arrayObject->ksort();

    return $arrayObject;
};

// ---------------------------------------------------------------------------------------------------------------------

$command = 'clear';
passthru($command);

// ---------------------------------------------------------------------------------------------------------------------

$counter   = 1;
$fileInfos = $getDemos();

foreach ($fileInfos as $fileInfo) {

    /** @var SplFileInfo $fileInfo */

    ConsoleUtils::writeLn('%d/%d) Executing "%s"...', $counter, $fileInfos->count(), $fileInfo->getFilename());
    ConsoleUtils::writeLn();
    $command = sprintf('%s %s', escapeshellarg(PHP_BINARY), escapeshellarg($fileInfo->getPathname()));
    passthru($command);
    ConsoleUtils::writeLn();
    ConsoleUtils::writeLn('...DONE.');
    ConsoleUtils::writeLn();

    $counter++;
}

// ---------------------------------------------------------------------------------------------------------------------
