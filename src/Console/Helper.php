<?php

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      http://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2018 Text Control GmbH
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
     * Name of username PHP constant or environmental variables
     *
     * @const REPORTING_CLOUD_API_KEY
     */
    const API_KEY = 'REPORTING_CLOUD_API_KEY';

    /**
     * Check that either the API key has been defined in environment variables
     *
     * @return bool
     */
    public static function checkCredentials()
    {
        if (null !== self::apiKey()) {
            return true;
        }

        return false;
    }

    /**
     * Return the value of the PHP constant or environmental variable
     *
     * @param string $variable Variable
     *
     * @return string|null
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
     * Return the ReportingCloud API key
     *
     * @return string|null
     */
    public static function apiKey()
    {
        return self::variable(self::API_KEY);
    }

    /**
     * Return error message explaining how to configure PHP constant or environmental variables
     *
     * @return string
     */
    public static function errorMessage()
    {
        $ret
            = <<<END

Error: ReportingCloud API key not defined.

In order to execute this script, you must first set your ReportingCloud
API key.

There are two ways in which you can do this:

1) Define the following PHP constant:

    define('REPORTING_CLOUD_API_KEY', 'your-api-key');

2) Set environmental variable (for example in .bashrc)
    
    export REPORTING_CLOUD_API_KEY='your-api-key'

Note, these instructions apply only to the demo scripts and phpunit tests.
When you use ReportingCloud in your application, set credentials in your
constructor or using the setApiKey(\$apiKey). For an example, see 
'/demo/instantiation.php'.

For further assistance and customer service please refer to:

    http://www.reporting.cloud

END;

        return $ret;
    }

    /**
     * Export variables to file
     *
     * @param string $filename Name of file to which to write
     * @param array  $values   Array of data
     *
     * @return bool|int
     */
    public static function varExportToFile($filename, array $values)
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

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Deprecated methods
     */

    /**
     * Return the ReportingCloud username
     *
     * @return null
     */
    public static function username()
    {
        $format  = '"%s" is deprecated - use an %s::apiKey instead';
        $message = sprintf($format, __METHOD__, __CLASS__);
        trigger_error($message, E_USER_DEPRECATED);

        return null;
    }

    /**
     * Return the ReportingCloud password
     *
     * @return null
     */
    public static function password()
    {
        $format  = '"%s" is deprecated - use an %s::apiKey instead';
        $message = sprintf($format, __METHOD__, __CLASS__);
        trigger_error($message, E_USER_DEPRECATED);

        return null;
    }
}
