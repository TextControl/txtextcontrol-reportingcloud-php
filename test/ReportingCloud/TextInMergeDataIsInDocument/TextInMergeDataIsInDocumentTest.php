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

namespace TxTextControlTest\ReportingCloud\TextInMergeDataIsInDocument;

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
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $reportingCloud;

    /**
     * @var PdfParser
     * @psalm-suppress PropertyNotSetInConstructor
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
        // $this->reportingCloud = null;
        // $this->pdfParser = null;
    }

    public function testTextInMergeDataIsInDocument(): void
    {
        $phpVersion = (string) phpversion();
        if (version_compare($phpVersion, '7.2.0', '>=')) {
            $format  = '%s does not work as expected in PHP 7.2 and newer';
            $message = sprintf($format, PdfParser::class);
            $this->markTestSkipped($message);
            return;
        }

        $fileTypes = [
            'TX',
            'DOCX',
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

            $arrayOfBinaryData = $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, $templateFilename);

            $this->assertArrayHasKey(0, $arrayOfBinaryData);

            file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

            $this->assertTrue(is_file($destinationFilename));
            $this->assertTrue(filesize($destinationFilename) > 0);

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
                $this->assertContains($value, $pdf->getText());
            }

            unlink($destinationFilename);

            $this->assertFalse(is_file($destinationFilename));
        }
    }
}
