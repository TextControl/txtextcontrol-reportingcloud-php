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
 * @copyright © 2022 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud\Stdlib;

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
        self::assertTrue($valid);
    }

    public function testReadBase64EncodeTrue(): void
    {
        $sourceFilename = $this->getTestDocumentFilename();

        $base64EncodedData = FileUtils::read($sourceFilename, true);
        $binaryData        = base64_decode($base64EncodedData, true);
        if (is_string($binaryData) && strlen($binaryData) > 0) {
            $valid = true;
        } else {
            $valid = false;
        }
        self::assertTrue($valid);
    }

    public function testWriteBase64EncodedFalse(): void
    {
        $sourceFilename      = $this->getTestDocumentFilename();
        $destinationFilename = $this->getTempDocumentFilename();

        $binaryData = FileUtils::read($sourceFilename, false);

        FileUtils::write($destinationFilename, $binaryData, false);

        $valid = file_exists($destinationFilename);
        self::assertTrue($valid);

        $binaryData = (string) file_get_contents($destinationFilename);
        $valid      = (preg_match(self::BINARY_PATTERN, $binaryData) > 0);
        self::assertTrue($valid);
    }

    public function testWriteBase64EncodedTrue(): void
    {
        $sourceFilename      = $this->getTestDocumentFilename();
        $destinationFilename = $this->getTempDocumentFilename();

        $binaryData = FileUtils::read($sourceFilename, true);

        FileUtils::write($destinationFilename, $binaryData, true);

        $valid = file_exists($destinationFilename);
        self::assertTrue($valid);

        $binaryData = (string) file_get_contents($destinationFilename);
        $valid      = (preg_match(self::BINARY_PATTERN, $binaryData) > 0);
        self::assertTrue($valid);
    }
}
