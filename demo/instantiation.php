<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate using constructor options

$reportingCloud = new ReportingCloud([
    'username' => Helper::username(),
    'password' => Helper::password(),
    'base_uri' => 'http://api.example.com',
    'timeout'  => 100,
    'version'  => 'v1',
    'debug'    => true,
]);

var_dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate using setter methods

$reportingCloud = new ReportingCloud();

$reportingCloud->setUsername(Helper::username());
$reportingCloud->setPassword(Helper::password());
$reportingCloud->setBaseUri('http://api.example.com');
$reportingCloud->setVersion('v1');
$reportingCloud->setTimeout(100);
$reportingCloud->getDebug(true);

var_dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate using setter methods (fluent interface)

$reportingCloud = new ReportingCloud();

$reportingCloud->setUsername(Helper::username())
               ->setPassword(Helper::password())
               ->setBaseUri('http://api.example.com')
               ->setVersion('v1')
               ->setTimeout(100)
               ->getDebug(true);

var_dump($reportingCloud);

// ---------------------------------------------------------------------------------------------------------------------