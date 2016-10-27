<?php

include_once 'bootstrap.php';

use TxTextControl\ReportingCloud\Console\Helper;

// ---------------------------------------------------------------------------------------------------------------------

define('TEST_PASS', 'PASS');
define('TEST_FAIL', 'FAIL');

define('MIN_PHP_VERSION', '5.5');

define('GEOIP_SERVICE_URI', 'http://freegeoip.net/json/');

// ---------------------------------------------------------------------------------------------------------------------

$failed  = false;
$counter = 1;

// ---------------------------------------------------------------------------------------------------------------------

Helper::writeLn(PHP_EOL);

Helper::writeLn('Environment Checker for the ReportingCloud PHP Wrapper' . PHP_EOL . PHP_EOL);

Helper::writeLn('If requested by technical support, please send the entire output of this script to the support engineers. The information contained within is vital to debug your environment. Thank you.' . PHP_EOL . PHP_EOL);

// ---------------------------------------------------------------------------------------------------------------------

Helper::writeLnToc($counter, sprintf('Checking OS (%s)', PHP_OS), TEST_PASS);

$counter++;

// ---------------------------------------------------------------------------------------------------------------------

if (1 === version_compare(PHP_VERSION, MIN_PHP_VERSION)) {
    $result = TEST_PASS;
} else {
    $result = TEST_FAIL;
    $failed = true;
}

Helper::writeLnToc($counter, sprintf('Checking PHP version (%s)', PHP_VERSION), $result);

$counter++;

// ---------------------------------------------------------------------------------------------------------------------

Helper::writeLnToc($counter, sprintf('Checking memory limit (%s)', ini_get('memory_limit')), TEST_PASS);

$counter++;

// ---------------------------------------------------------------------------------------------------------------------

if (in_array('http', stream_get_wrappers())) {
    $result = TEST_PASS;
} else {
    $result = TEST_FAIL;
    $failed = true;
}

Helper::writeLnToc($counter, 'Checking HTTP stream wrapper', $result);

$counter++;

// ---------------------------------------------------------------------------------------------------------------------

if (in_array('https', stream_get_wrappers())) {
    $result = TEST_PASS;
} else {
    $result = TEST_FAIL;
    $failed = true;
}

Helper::writeLnToc($counter, 'Checking HTTPS stream wrapper', $result);

$counter++;

// ---------------------------------------------------------------------------------------------------------------------

if (extension_loaded('openssl')) {
    $version = OPENSSL_VERSION_TEXT;
    $result  = TEST_PASS;
} else {
    $version = 'N/A';
    $result  = TEST_FAIL;
    $failed  = true;
}

Helper::writeLnToc($counter, sprintf('Checking OpenSSL extension (%s)', $version), $result);

$counter++;

// ---------------------------------------------------------------------------------------------------------------------

if (extension_loaded('curl')) {
    $curl    = curl_version();
    $version = $curl['version'];
    $result  = TEST_PASS;
} else {
    $version = 'N/A';
    $result  = TEST_FAIL;
    $failed  = true;
}

Helper::writeLnToc($counter, sprintf('Checking curl extension (%s)', $version), $result);

$counter++;

// ---------------------------------------------------------------------------------------------------------------------

if (is_readable('../vendor/autoload.php')) {
    $result = TEST_PASS;
} else {
    $result = TEST_FAIL;
    $failed = true;
}

Helper::writeLnToc($counter, sprintf('Checking composer\'s "/vendor/autoload.php"', $version), $result);

$counter++;

// ---------------------------------------------------------------------------------------------------------------------

$results = @file_get_contents(GEOIP_SERVICE_URI);

if (false != $results) {
    $lut = [
        'ip'           => 'IP address',
        'city'         => 'City',
        'region_name'  => 'region',
        'country_name' => 'country',
    ];
    $results = json_decode($results);
    foreach (array_keys($lut) as $key) {
        if (isset($results->$key)) {
            $value = trim($results->$key);
            if (strlen($value) > 0) {
                Helper::writeLnToc($counter, sprintf('Checking your %s (%s)', $lut[$key], $value), TEST_PASS);
                $counter++;
            }
        }
    }
} else {
    Helper::writeLnToc($counter, 'Checking your geo data', TEST_FAIL);
    $failed = true;
    $counter++;
}

// ---------------------------------------------------------------------------------------------------------------------

if (true === $failed) {
    $message = 'One or more tests failed. The web server environment, in which this script is running, does not meet the requirements for the ReportingCloud PHP wrapper.';
} else {
    $message = 'Congratulations! All required tests passed. The server environment, in which this script is running, is suitable for the ReportingCloud PHP wrapper.';
}

Helper::writeLn(PHP_EOL);
Helper::writeLn($message);
Helper::writeLn(PHP_EOL);
Helper::writeLn(PHP_EOL);

// ---------------------------------------------------------------------------------------------------------------------