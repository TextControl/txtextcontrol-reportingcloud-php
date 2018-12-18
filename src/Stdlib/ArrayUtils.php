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

use Riimu\Kit\PHPEncoder\PHPEncoder;

/**
 * Class ArrayUtils
 *
 * @package TxTextControl\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ArrayUtils extends AbstractStdlib
{
    /**
     * Write the array of passed data to a file as a PHP structure
     *
     * @param string $filename
     * @param array  $values
     *
     * @return int
     */
    public static function varExportToFile(string $filename, array $values): int
    {
        $options = [
            'array.indent'  => 4,
            'array.align'   => true,
            'array.omit'    => true,
            'array.short'   => true,
            'object.format' => 'export',
            'string.utf8'   => true,
            'whitespace'    => true,
        ];

        $encoder = new PHPEncoder($options);

        $buffer = '<?php';
        $buffer .= PHP_EOL;
        $buffer .= 'declare(strict_types=1);';
        $buffer .= PHP_EOL . PHP_EOL;
        $buffer .= 'return ';
        $buffer .= $encoder->encode($values);
        $buffer .= ';';
        $buffer .= PHP_EOL;

        return (int) file_put_contents($filename, $buffer);
    }
}
