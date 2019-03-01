<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

// Instantiate with API key via constructor option

$reportingCloud = new ReportingCloud([
    'api_key' => 'xxxxxxxx',
]);

ConsoleUtils::dump($reportingCloud);


// Instantiate with API key via setter method

$reportingCloud = new ReportingCloud();

$reportingCloud->setApiKey('xxxxxxxx');

ConsoleUtils::dump($reportingCloud);

/*
 * The following instantiation methods are deprecated and will be removed from a future version of the PHP SDK.
 * Please do not use them for new projects, and refactor them out for current projects
 *
 * // Instantiate with username and password via constructor options
 * // @deprecated: Use the API key method instead (see above)
 *
 * $reportingCloud = new ReportingCloud([
 *     'username' => 'xxxxxxxx',
 *     'password' => 'xxxxxxxx',
 *     'base_uri' => 'http://api.example.com',
 *     'timeout'  => 100,
 *     'version'  => 'v1',
 *     'debug'    => true,
 * ]);
 *
 * ConsoleUtils::dump($reportingCloud);
 *
 *
 * // Instantiate with username and password via setter methods
 * // @deprecated: Use the API key method instead (see above)
 *
 * $reportingCloud = new ReportingCloud();
 *
 * $reportingCloud->setUsername('xxxxxxxx');
 * $reportingCloud->setPassword('xxxxxxxx');
 * $reportingCloud->setBaseUri('http://api.example.com');
 * $reportingCloud->setVersion('v1');
 * $reportingCloud->setTimeout(100);
 * $reportingCloud->setDebug(true);
 *
 * ConsoleUtils::dump($reportingCloud);
 *
 */
