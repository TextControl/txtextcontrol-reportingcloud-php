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

namespace TxTextControlTest\ReportingCloud\Path;

use TxTextControl\ReportingCloud\Stdlib\FileUtils;
use TxTextControlTest\ReportingCloud\AbstractReportingCloudTest;

/**
 * Class FileUtilsTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class FileUtilsTest extends AbstractReportingCloudTest
{
    const BINARY_PATTERN = '~[^\x20-\x7E\t\r\n]~';

    public function testReadBase64EncodeFalse(): void
    {
        $sourceFilename = $this->getTestDocumentFilename();

        $binaryData = FileUtils::read($sourceFilename);
        $valid      = (preg_match(self::BINARY_PATTERN, $binaryData) > 0);
        $this->assertTrue($valid);
    }

    public function testReadBase64EncodeTrue(): void
    {
        $sourceFilename = $this->getTestDocumentFilename();

        $base64EncodedData = FileUtils::read($sourceFilename, true);
        if (base64_decode($base64EncodedData, true)) {
            $valid = true;
        } else {
            $valid = false;
        }
        $this->assertTrue($valid);
    }

    public function testWriteBase64EncodedFalse(): void
    {
        $sourceFilename      = $this->getTestDocumentFilename();
        $destinationFilename = $this->getTempDocumentFilename();

        $binaryData = FileUtils::read($sourceFilename, false);

        FileUtils::write($destinationFilename, $binaryData, false);

        $valid = file_exists($destinationFilename);
        $this->assertTrue($valid);

        $binaryData = file_get_contents($destinationFilename);
        $valid      = (preg_match(self::BINARY_PATTERN, $binaryData) > 0);
        $this->assertTrue($valid);
    }

    public function testWriteBase64EncodedTrue(): void
    {
        $sourceFilename      = $this->getTestDocumentFilename();
        $destinationFilename = $this->getTempDocumentFilename();

        $binaryData = FileUtils::read($sourceFilename, true);

        FileUtils::write($destinationFilename, $binaryData, true);

        $valid = file_exists($destinationFilename);
        $this->assertTrue($valid);

        $binaryData = file_get_contents($destinationFilename);
        $valid      = (preg_match(self::BINARY_PATTERN, $binaryData) > 0);
        $this->assertTrue($valid);
    }
}
