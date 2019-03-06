<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP SDK
 *
 * PHP SDK for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControl\ReportingCloud\Stdlib;

/**
 * Class FileUtils
 *
 * @package TxTextControl\ReportingCloud
 */
class FileUtils extends AbstractStdlib
{
    /**
     * Read a filename from filesystem and return its binary data.
     * Optionally base64 encoding the returned binary data.
     *
     * @param string $filename
     * @param bool   $base64Encode
     *
     * @return string
     */
    public static function read(string $filename, bool $base64Encode = false): string
    {
        $binaryData = (string) file_get_contents($filename);

        if ($base64Encode) {
            $binaryData = (string) base64_encode($binaryData);
        }

        return $binaryData;
    }

    /**
     * Write binary data to a filename on filesystem.
     * Optionally based decode it first.
     *
     * @param string $filename
     * @param string $binaryData
     * @param bool   $base64Encoded
     *
     * @return bool
     */
    public static function write(string $filename, string $binaryData, bool $base64Encoded = false): bool
    {
        if ($base64Encoded) {
            $binaryData = (string) base64_decode($binaryData);
        }

        $result = file_put_contents($filename, $binaryData);

        if (is_int($result) && $result > 0) {
            $ret = true;
        } else {
            $ret = false;
        }

        return $ret;
    }
}
