<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2016 Text Control GmbH
 */
namespace TxTextControl\ReportingCloud\Console;

/**
 * ReportingCloud console helper (used only for tests and demos)
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class Helper
{
    /**
     * Line length in characters (used to wrap long lines)
     */
    const LINE_LENGTH = 80;

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
        $username = self::variable(self::USERNAME);

        return $username;
    }

    /**
     * Return the ReportingCloud password
     *
     * @return null|string
     */
    public static function password()
    {
        $password = self::variable(self::PASSWORD);

        return $password;
    }

    /**
     * Check ReportingCloud credentials, which have been defined in environment variables, otherwise terminate script
     * execution with error code 1
     */
    public static function checkCredentials()
    {
        if (null === self::username() || null === self::password()) {
            echo self::errorMessage();
            die(1);
        }

        return true;
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
        } else {
            $value = getenv($variable);
        }

        $value = trim($value);

        if (strlen($value) > 0) {
            $ret = $value;
        }

        return $ret;
    }

    /**
     * Print line, wrapped at self::LINE_LENGTH th character
     *
     * @param string $string String
     * @return string
     */
    public static function writeLn($string)
    {
        print wordwrap($string, self::LINE_LENGTH);
    }

    /**
     * Print result line like in a table of contents i.e.:
     *
     * n: XXX YYY ZZZ....ZZZ
     *
     * @param integer $counter    Counter
     * @param string  $testString Test string
     * @param string  $testResult Test result
     */
    public static function writeLnToc($counter, $testString, $testResult)
    {
        $lineLength = self::LINE_LENGTH;
        $padding    = $lineLength - (4 + strlen(TEST_PASS));
        $counter    = sprintf('%2s: ', $counter);
        $testString = str_pad($testString, $padding, '.', STR_PAD_RIGHT);

        printf('%s%s%s%s', $counter, $testString, $testResult, PHP_EOL);
    }

}