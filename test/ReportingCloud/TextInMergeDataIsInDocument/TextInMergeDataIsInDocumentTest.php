<?php

namespace TxTextControlTest\ReportingCloud\TextInMergeDataIsInDocument;

use PHPUnit_Framework_TestCase;
use Smalot\PdfParser\Parser as PdfParser;
use TxTextControl\ReportingCloud\CliHelper as Helper;
use TxTextControl\ReportingCloud\ReportingCloud;

class TextInMergeDataIsInDocumentTest extends PHPUnit_Framework_TestCase
{
    protected $reportingCloud;

    protected $pdfParser;

    public function setUp()
    {
        $this->reportingCloud = new ReportingCloud();
        $this->reportingCloud->setUsername(Helper::username());
        $this->reportingCloud->setPassword(Helper::password());

        $this->pdfParser = new PdfParser();
    }

    public function testTextInMergeDataIsInDocument()
    {
        $fileTypes = [
            'TX',
            'DOCX'
        ];

        foreach ($fileTypes as $fileType) {

            $fileExtension = strtolower($fileType);

            $templateFilename    = __DIR__ . DIRECTORY_SEPARATOR
                                    . sprintf('template.%s', $fileExtension);

            $destinationFilename = sys_get_temp_dir() . DIRECTORY_SEPARATOR
                                    . sprintf('%s.pdf', hash('sha256', $fileExtension . microtime(true)));

            $mergeDataFilename   = __DIR__ . DIRECTORY_SEPARATOR . 'merge_data.json';

            $mergeData = json_decode(file_get_contents($mergeDataFilename));

            $arrayOfBinaryData = $this->reportingCloud->mergeDocument($mergeData, 'PDF', null, $templateFilename);

            file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

            $this->assertTrue(is_file($destinationFilename));
            $this->assertTrue(filesize($destinationFilename) > 0);

            $pdf = $this->pdfParser->parseFile($destinationFilename);

            // row 1
            $this->assertGreaterThan(0, strpos($pdf->getText(), 'OrJb'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), 'xeBl'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), 'mHaU'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), '9SzE'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), '4IQJ'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), 'SfGk'));

            // row 2
            $this->assertGreaterThan(0, strpos($pdf->getText(), '56fv'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), 'fklW'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), 'Ykva'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), 'HlLU'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), 'JGgT'));
            $this->assertGreaterThan(0, strpos($pdf->getText(), '3jOS'));

            unlink($destinationFilename);

            $this->assertFalse(is_file($destinationFilename));

        }
    }

}