<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/ReportingCloud.PHP for the canonical source repository
 * @license   https://github.com/TextControl/ReportingCloud.PHP/LICENSE.md New BSD License
 * @copyright © 2016 Text Control GmbH
 */

/**
 * Return the ReportingCloud username
 *
 * @return null|string
 */
function reporting_cloud_username()
{
    return reporting_cloud_variable('REPORTING_CLOUD_USERNAME');
}

/**
 * Return the ReportingCloud password
 *
 * @return null|string
 */
function reporting_cloud_password()
{
    return reporting_cloud_variable('REPORTING_CLOUD_PASSWORD');
}

/**
 * Return the value of the variable set as a constant or environmental variable
 *
 * @param string $variable Variable
 *
 * @return null|string
 */
function reporting_cloud_variable($variable)
{
    $ret   = null;
    $value = null;

    if (defined($variable)) {
        $value = constant($variable);
        $value = trim($value);
    } else {
        $value = getenv($variable);
        $value = trim($value);
    }

    if (strlen($value) > 0) {
        $ret = $value;
    }

    return $ret;
}

/**
 * Return error message explaining how to configure REPORTING_CLOUD_USERNAME and REPORTING_CLOUD_PASSWORD constants or
 * environmental variables
 *
 * @return string
 */
function reporting_cloud_error_message()
{
    $ret = <<<END
    
Error: ReportingCloud username and/or password not defined.

In order to execute this script, you must first set your ReportingCloud username and password.

There are two ways in which you can do this:

1) Define the following PHP constants:

    define('REPORTING_CLOUD_USERNAME', 'your-username');
    define('REPORTING_CLOUD_PASSWORD', 'your-password');

2) Set environmental variables (for example in .bashrc)
    
    export REPORTING_CLOUD_USERNAME='your-username'
    export REPORTING_CLOUD_PASSWORD='your-password'

Note, these instructions apply only to the phpunit and demo scripts. When you use ReportingCloud in your application, set the username and password in your constructor or using the setUsername(\$username) and setPassword(\$password) methods. For an example of this case, see 'demo/instantiation.php'.

For further assistance and customer service please refer to:

    http:/reporting.cloud


END;

    return wordwrap($ret, 80);
}

if (null === reporting_cloud_username() || null === reporting_cloud_password()) {
    echo reporting_cloud_error_message();
    exit();
}