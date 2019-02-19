<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Return an array of fileInfos which should be executed
 *
 * @return array
 *
 */
$getFileInfos = function (): array {

    $ret = [];

    $di = new DirectoryIterator(__DIR__);
    foreach ($di as $fileInfo) {
        if (__FILE__ === $fileInfo->getPathname()) {
            continue;
        }
        if (in_array($fileInfo->getFilename(), ['bootstrap.php', 'constants.php', 'init.php'])) {
            continue;
        }
        if ('php' !== $fileInfo->getExtension()) {
            continue;
        }
        $ret[] = clone $fileInfo;
    }

    return $ret;
};

// ---------------------------------------------------------------------------------------------------------------------

$command = 'clear';
passthru($command);

$fileInfos = $getFileInfos();
$count     = count($fileInfos);
$counter   = 0;

foreach ($fileInfos as $fileInfo) {

    $counter++;

    echo sprintf('%d/%d) Executing "%s"...', $counter, $count, $fileInfo->getFilename());
    echo PHP_EOL;
    echo PHP_EOL;

    $command = sprintf('%s %s', PHP_BINARY, $fileInfo->getPathname());
    passthru($command);

    echo PHP_EOL;
    echo '...DONE.';
    echo PHP_EOL;
    echo PHP_EOL;
    echo PHP_EOL;
}

// ---------------------------------------------------------------------------------------------------------------------
