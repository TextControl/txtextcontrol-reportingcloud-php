<?php

use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\CliHelper as Helper;

$filenameAutoload = realpath(__DIR__ . '/../vendor/autoload.php');

if (!is_readable($filenameAutoload)) {
    throw new RuntimeException("Cannot load composer's autoload.php file. Did you run composer install?");
}

include_once $filenameAutoload;

// ---------------------------------------------------------------------------------------------------------------------

if (null === Helper::username() || null === Helper::password()) {
    echo Helper::errorMessage();
    exit(1);
}

// ---------------------------------------------------------------------------------------------------------------------
