<?php

use TxTextControl\ReportingCloud\Console\Helper;

// ---------------------------------------------------------------------------------------------------------------------

$filenameAutoload = call_user_func(function () {

    $ret = null;

    $file = 'autoload.php';

    $filenameDep = __DIR__ . '/../../../' . $file;  // when installed as a dependency to another project
    $filenameGit = __DIR__ . '/../vendor/'. $file;  // when installed as a GIT clone

    if (is_readable($filenameDep)) {
        $ret = $filenameDep;
    } elseif (is_readable($filenameGit)) {
        $ret = $filenameGit;
    } else {
        $message = sprintf("Cannot load composer's %s. Tried: '%s', '%s'). Did you run 'composer install'?"
            , $file
            , $filenameDep
            , $filenameGit
        );
        throw new RuntimeException($message);
    }

    return realpath($ret);

});

include_once $filenameAutoload;

// ---------------------------------------------------------------------------------------------------------------------

Helper::checkCredentials();

// ---------------------------------------------------------------------------------------------------------------------

switch (basename(getcwd())) {

    case 'demo':

        $outputPath = __DIR__ . '/output';

        if (!is_dir($outputPath)) {
            mkdir($outputPath);
        }

        define('REPORTING_CLOUD_DEMO_OUTPUT_PATH', $outputPath);
        define('REPORTING_CLOUD_DEMO_MEDIA_PATH' , realpath(__DIR__ . '/../media'));

        break;
}

// ---------------------------------------------------------------------------------------------------------------------