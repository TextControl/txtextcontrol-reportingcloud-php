<?php

namespace TxTextControlTest\ReportingCloud\TextInMergeDataIsInDocument;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser as PdfParser;
use TxTextControl\ReportingCloud\Console\Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

class TextInMergeDataIsInDocumentTest extends TestCase
{
    protected $reportingCloud;

    protected $pdfParser;

    public function setUp()
    {
        $this->reportingCloud = new ReportingCloud();
        $this->reportingCloud->setApiKey(Helper::apiKey());

        $this->pdfParser = new PdfParser();
    }

    public function testTextInMergeDataIsInDocument()
    {
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

            $mergeData = json_decode(file_get_contents($mergeDataFilename));

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
