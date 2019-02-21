<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Return an array of filenames which should be executed
 *
 * @return array
 *
 */
$getFilenames = function (): array {

    $ret = [];

    $di = new DirectoryIterator(__DIR__);
    foreach ($di as $fileInfo) {
        if (in_array($fileInfo->getFilename(), [basename(__FILE__), 'bootstrap.php', 'init.php'])) {
            continue;
        }
        if ('php' !== $fileInfo->getExtension()) {
            continue;
        }
        $ret[] = (string) $fileInfo->getPathname();
    }

    sort($ret);

    return $ret;
};

// ---------------------------------------------------------------------------------------------------------------------

$command = 'clear';
passthru($command);

// ---------------------------------------------------------------------------------------------------------------------

$filenames = $getFilenames();
$count     = count($filenames);
$counter   = 0;

foreach ($filenames as $filename) {

    $counter++;

    $filename = (string) $filename;

    echo sprintf('%d/%d) Executing "%s"...', $counter, $count, basename($filename));
    echo PHP_EOL;
    echo PHP_EOL;

    $command = sprintf('%s %s', PHP_BINARY, escapeshellarg($filename));
    passthru($command);

    echo PHP_EOL;
    echo '...DONE.';
    echo PHP_EOL;
    echo PHP_EOL;
    echo PHP_EOL;
}

// ---------------------------------------------------------------------------------------------------------------------
