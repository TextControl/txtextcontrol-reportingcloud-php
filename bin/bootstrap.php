<?php

use TxTextControl\ReportingCloud\Console\Helper;

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Export variables to file
 *
 * @param $filename
 * @param $values
 *
 * @return bool|int
 */
function var_export_file($filename, $values)
{
    $buffer = '<?php';
    $buffer .= PHP_EOL;
    $buffer .= PHP_EOL;
    $buffer .= 'return ';
    $buffer .= var_export($values, true);
    $buffer .= ';';
    $buffer .= PHP_EOL;

    return file_put_contents($filename, $buffer);
}

// ---------------------------------------------------------------------------------------------------------------------

$autoloadFilename = call_user_func(function () {

    $ret = null;

    $file = 'autoload.php';         // standard composer autoload file

    $paths = [
        __DIR__ . '/../../..',      // when installed as a dependency to another project
        __DIR__ . '/../vendor',     // when installed as a GIT clone
    ];

    foreach ($paths as $path) {
        $filename = $path . DIRECTORY_SEPARATOR . $file;
        if (is_readable($filename)) {
            $ret = realpath($filename);
            break;
        }
    }

    if (null === $ret) {
        $message = sprintf("Cannot load composer's %s. Tried %s. Did you run 'composer install'?"
            , $file
            , implode(', ', $paths)
        );
        throw new RuntimeException($message);
    }

    return $ret;

});

include $autoloadFilename;

// ---------------------------------------------------------------------------------------------------------------------

Helper::checkCredentials();

// ---------------------------------------------------------------------------------------------------------------------

switch (basename(getcwd())) {

    case 'demo':

        $outputPath = dirname(__DIR__) . '/demo/output';

        if (!is_dir($outputPath)) {
            mkdir($outputPath);
        }

        define('REPORTING_CLOUD_DEMO_OUTPUT_PATH', $outputPath);
        define('REPORTING_CLOUD_DEMO_MEDIA_PATH' , realpath(__DIR__ . '/../media'));

        break;
}

// ---------------------------------------------------------------------------------------------------------------------
