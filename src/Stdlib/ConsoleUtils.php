<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Stdlib;

/**
 * ReportingCloud console helper (used only for tests and demos)
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ConsoleUtils extends AbstractStdlib
{
    /**
     * Name of PHP constant or environmental variable storing API key
     *
     * @const REPORTING_CLOUD_API_KEY
     */
    private const API_KEY = 'REPORTING_CLOUD_API_KEY';

    /**
     * Check that either the API key has been defined in environment variables
     *
     * @return bool
     */
    public static function checkCredentials(): bool
    {
        if (null !== self::apiKey()) {
            return true;
        }

        return false;
    }

    /**
     * Return the ReportingCloud API key from a PHP constant or environmental variable
     *
     * @return string|null
     */
    public static function apiKey(): ?string
    {
        $key = self::API_KEY;

        if (defined($key)) {
            $ret = (string) constant($key);
            $ret = trim($ret);
            return $ret;
        }

        if (getenv($key)) {
            $ret = (string) getenv($key);
            $ret = trim($ret);
            return $ret;
        }

        return null;
    }

    /**
     * Return error message explaining how to configure PHP constant or environmental variables
     *
     * @return string
     */
    public static function errorMessage(): string
    {
        $format
                  = <<<END

Error: ReportingCloud API key not defined.

In order to execute %s, you must first set your ReportingCloud API key.

There are two ways in which you can do this:

1) Define the following PHP constant:

    define('%s', '%s');

2) Set environmental variable (for example in .bashrc)
    
    export %s='%s'

Note, these instructions apply only to the demo scripts and phpunit tests. 
When you use ReportingCloud in your application, set credentials in your constructor 
or using the setApiKey(\$apiKey). For an example, see '/demo/instantiation.php'.

For further assistance and customer service please refer to:

    https://www.reporting.cloud

END;
        $filename = (string) $_SERVER['argv'][0] ?? '';
        $filename = realpath($filename);

        if (is_bool($filename)) {
            $name = 'this script';
        } else {
            $base = dirname(__FILE__, 3);
            $file = str_replace($base, '', $filename);
            $name = sprintf("'%s'", $file);
        }

        $key   = self::API_KEY;
        $value = 'your-api-key';

        $ret = sprintf($format, $name, $key, $value, $key, $value);
        $ret = wordwrap($ret, 80);

        return $ret;
    }
}
