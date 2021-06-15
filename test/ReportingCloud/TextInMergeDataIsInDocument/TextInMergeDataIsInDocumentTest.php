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

namespace TxTextControlTest\ReportingCloud\ReportingCloud\TextInMergeDataIsInDocument;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser as PdfParser;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

/**
 * Class TextInMergeDataIsInDocumentTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class TextInMergeDataIsInDocumentTest extends TestCase
{
    /**
     * @var ReportingCloud
     */
    protected $reportingCloud;

    /**
     * @var PdfParser
     */
    protected $pdfParser;

    public function setUp(): void
    {
        $this->reportingCloud = new ReportingCloud([
            'api_key' => ConsoleUtils::apiKey()
        ]);

        $this->pdfParser = new PdfParser();
    }

    public function tearDown(): void
    {
        unset($this->reportingCloud);
        unset($this->pdfParser);
    }

    public function testTextInMergeDataIsInDocument(): void
    {
        $fileTypes = [
            ReportingCloud::FILE_FORMAT_TX,
            ReportingCloud::FILE_FORMAT_DOCX,
        ];

        foreach ($fileTypes as $fileType) {

            $fileExtension = strtolower($fileType);

            $templateFilename = __DIR__ . DIRECTORY_SEPARATOR . sprintf('template.%s', $fileExtension);

            $destinationFilename = sys_get_temp_dir() . DIRECTORY_SEPARATOR . sprintf(
                '%s.pdf',
                hash('sha256', $fileExtension . microtime(true))
            );

            $mergeDataFilename = __DIR__ . DIRECTORY_SEPARATOR . 'merge_data.json';

            $json      = (string) file_get_contents($mergeDataFilename);
            $mergeData = (array)  json_decode($json, true);

            $arrayOfBinaryData = $this->reportingCloud->mergeDocument(
                $mergeData,
                ReportingCloud::FILE_FORMAT_PDF,
                '',
                $templateFilename
            );

            self::assertArrayHasKey(0, $arrayOfBinaryData);

            file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

            self::assertTrue(is_file($destinationFilename));
            self::assertTrue(filesize($destinationFilename) > 0);

            $pdf = $this->pdfParser->parseFile($destinationFilename);

            $expected = [
                // row 1
                'OrJb',
                'xeBl',
                'mHaU',
                '9SzE',
                '4IQJ',
                'SfGk',
                // row 2
                '56fv',
                'fklW',
                'Ykva',
                'HlLU',
                'JGgT',
                '3jOS',
            ];

            foreach ($expected as $value) {
                self::assertStringContainsString($value, $pdf->getText());
            }

            unlink($destinationFilename);

            self::assertFalse(is_file($destinationFilename));
        }
    }
}
