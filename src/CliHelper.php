<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * Official wrapper (authored by Text Control GmbH, publisher of ReportingCloud) to access ReportingCloud in PHP.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud;

/**
 * ReportingCloud
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class CliHelper
{
    /**
     * Name of username PHP constant or environmental variables
     *
     * @const REPORTING_CLOUD_USERNAME
     */
    const USERNAME = 'REPORTING_CLOUD_USERNAME';

    /**
     * Name of password PHP constant or environmental variables
     *
     * @const REPORTING_CLOUD_PASSWORD
     */
    const PASSWORD = 'REPORTING_CLOUD_PASSWORD';

    /**
     * Return error message explaining how to configure PHP constant or environmental variables
     *
     * @return string
     */
    public static function errorMessage()
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

    http://www.reporting.cloud


END;

        return wordwrap($ret, 80);
    }

    /**
     * Return the ReportingCloud username
     *
     * @return null|string
     */
    public static function username()
    {
        return self::variable(self::USERNAME);
    }

    /**
     * Return the ReportingCloud password
     *
     * @return null|string
     */
    public static function password()
    {
        return self::variable(self::PASSWORD);
    }

    /**
     * Return the value of the PHP constant or environmental variable
     *
     * @param string $variable Variable
     *
     * @return null|string
     */
    protected static function variable($variable)
    {
        $ret = null;

        if (defined($variable)) {
            $value = constant($variable);
            $value = trim($value);
        } else {
            $value = getenv($variable);
            $value = trim($value);
        }

        if (!empty($value)) {
            $ret = $value;
        }

        return $ret;
    }

}