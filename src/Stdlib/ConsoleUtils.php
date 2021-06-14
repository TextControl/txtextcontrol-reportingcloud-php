<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://git.io/Jejj2 for the canonical source repository
 * @license   https://git.io/Jejjr
 * @copyright © 2021 Text Control GmbH
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
    public const API_KEY = 'REPORTING_CLOUD_API_KEY';

    /**
     * Name of PHP constant or environmental variable storing base URI
     *
     * @const REPORTING_CLOUD_BASE_URI
     */
    public const BASE_URI = 'REPORTING_CLOUD_BASE_URI';

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
        return self::getValueFromConstOrEnvVar(self::API_KEY);
    }

    /**
     * Return the ReportingCloud base URI from a PHP constant or environmental variable
     *
     * @return string|null
     */
    public static function baseUri(): ?string
    {
        return self::getValueFromConstOrEnvVar(self::BASE_URI);
    }

    /**
     * Return error message explaining how to configure PHP constant or environmental variables
     *
     * @return string
     */
    public static function errorMessage(): string
    {
        $format   = <<<END

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
        $filename = $_SERVER['argv'][0] ?? '';
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

    /**
     * Dump information about a variable
     * (var_dump is wrapped to suppress psalm warning)
     *
     * @param mixed|null $array
     *
     */
    public static function dump($array): void
    {
        var_dump($array);
    }

    /**
     * Write a line to the console
     *
     * @param string $format
     * @param mixed  ...$args
     */
    public static function writeLn(string $format = '', ...$args): void
    {
        $args = (array) $args;

        if (count($args) > 0) {
            echo vsprintf($format, $args);
        } else {
            echo $format;
        }

        echo PHP_EOL;
    }

    /**
     * Return a value from a PHP constant or environmental variable
     *
     * @param string $key
     *
     * @return string|null
     */
    private static function getValueFromConstOrEnvVar(string $key): ?string
    {
        $ret = self::getValueFromConst($key);

        if (null !== $ret) {
            return $ret;
        }

        $ret = self::getValueFromEnvVar($key);

        if (null !== $ret) {
            return $ret;
        }

        return null;
    }

    /**
     * Return a value from a PHP constant
     *
     * @param string $key
     *
     * @return string|null
     */
    private static function getValueFromConst(string $key): ?string
    {
        if (defined($key)) {
            $ret = (string) constant($key);
            $ret = trim($ret);
            if (!empty($ret)) {
                return $ret;
            }
        }

        return null;
    }
    /**
     * Return a value from an environmental variable
     *
     * @param string $key
     *
     * @return string|null
     */
    private static function getValueFromEnvVar(string $key): ?string
    {
        if (getenv($key)) {
            $ret = (string) getenv($key);
            $ret = trim($ret);
            if (!empty($ret)) {
                return $ret;
            }
        }

        return null;
    }
}
