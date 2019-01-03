<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;

trait DeleteTraitTest
{
    // <editor-fold desc="deleteApiKey">

    public function testDeleteApiKey()
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($apiKey);

        $response = $this->reportingCloud->deleteApiKey($apiKey);
        $this->assertTrue($response);
    }

    // </editor-fold>

    // <editor-fold desc="deleteTemplate">

    public function testDeleteTemplate()
    {
        $testTemplateFilename = $this->getTestTemplateFilename();
        $tempTemplateFilename = $this->getTempTemplateFilename();
        $tempTemplateName     = basename($tempTemplateFilename);

        $this->assertFileExists($testTemplateFilename);

        copy($testTemplateFilename, $tempTemplateFilename);
        $this->assertFileExists($tempTemplateFilename);

        $response = $this->reportingCloud->uploadTemplate($tempTemplateFilename);
        $this->assertTrue($response);

        $templateNames = [];
        $templateList  = $this->reportingCloud->getTemplateList();
        foreach ($templateList as $record) {
            $templateNames[] = $record['template_name'];
        }
        $this->assertContains($tempTemplateName, $templateNames);

        $response = $this->reportingCloud->deleteTemplate($tempTemplateName);
        $this->assertTrue($response);

        unlink($tempTemplateFilename);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testDeleteTemplateInvalidTemplateName()
    {
        $templateName = $this->getTestTemplateFilename();
        $this->reportingCloud->deleteTemplate($templateName);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testDeleteTemplateRuntimeException()
    {
        $this->reportingCloud->deleteTemplate('invalid-template.tx');
    }

    // </editor-fold>
}
