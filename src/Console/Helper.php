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

namespace TxTextControl\ReportingCloud\Console;

use Riimu\Kit\PHPEncoder\PHPEncoder;

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
    protected const API_KEY = 'REPORTING_CLOUD_API_KEY';

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
     * Return the value of the PHP constant or environmental variable
     *
     * @param string $variable Variable
     *
     * @return string|null
     */
    protected static function variable(string $variable): ?string
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
    public static function apiKey(): ?string
    {
        return self::variable(self::API_KEY);
    }

    /**
     * Return error message explaining how to configure PHP constant or environmental variables
     *
     * @return string
     */
    public static function errorMessage(): string
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

    https://www.reporting.cloud

END;

        return $ret;
    }

    /**
     * Write the array of passed data to a file as a PHP structure
     *
     * @param string $filename
     * @param array  $values
     *
     * @return int
     */
    public function varExportToFile(string $filename, array $values): int
    {
        $encoder = new PHPEncoder([
            'array.short'   => true,
            'array.omit'    => true,
            'object.format' => 'export',
            'string.utf8'   => true,
            'whitespace'    => true,
        ]);

        $data = '<?php';
        $data .= PHP_EOL;
        $data .= 'declare(strict_types=1);';
        $data .= PHP_EOL;
        $data .= PHP_EOL;
        $data .= 'return ';
        $data .= $encoder->encode($values);
        $data .= ';';
        $data .= PHP_EOL;

        return (int) file_put_contents($filename, $data);
    }
}
