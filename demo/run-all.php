<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

$command = 'clear';
passthru($command);

$di = new DirectoryIterator(__DIR__);

foreach ($di as $fileInfo) {

    if (__FILE__ === $fileInfo->getPathname()) {
        continue;
    }

    if ('php' !== $fileInfo->getExtension()) {
        continue;
    }

    echo sprintf('Executing %s...', $fileInfo->getFilename());
    echo PHP_EOL . PHP_EOL;

    $command = sprintf('%s %s', PHP_BINARY, $fileInfo->getPathname());
    passthru($command);

    echo PHP_EOL;
    echo "...DONE.";
    echo PHP_EOL . PHP_EOL . PHP_EOL;
}
