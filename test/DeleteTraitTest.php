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
 * @copyright © 2020 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\Exception\RuntimeException;
use TxTextControl\ReportingCloud\ReportingCloud;

/**
 * Trait DeleteTraitTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait DeleteTraitTest
{
    /**
     * @var ReportingCloud
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $reportingCloud;

    // <editor-fold desc="Abstract methods">

    /**
     * @param mixed  $actual
     * @param string $message
     */
    abstract public static function assertNotEmpty($actual, string $message = ''): void;

    /**
     * @param mixed  $condition
     * @param string $message
     */
    abstract public static function assertTrue($condition, string $message = ''): void;

    /**
     * @param string $filename
     * @param string $message
     */
    abstract public static function assertFileExists(string $filename, string $message = ''): void;

    /**
     * @param mixed  $needle
     * @param mixed  $haystack
     * @param string $message
     * @param bool   $ignoreCase
     * @param bool   $checkForObjectIdentity
     * @param bool   $checkForNonObjectIdentity
     */
    abstract public static function assertContains(
        $needle,
        $haystack,
        string $message = '',
        bool $ignoreCase = false,
        bool $checkForObjectIdentity = true,
        bool $checkForNonObjectIdentity = false
    ): void;

    /**
     * @param string $exception
     */
    abstract public function expectException(string $exception): void;

    /**
     * @return string
     */
    abstract protected function getTestTemplateFilename(): string;

    /**
     * @return string
     */
    abstract protected function getTempTemplateFilename(): string;

    /**
     *
     */
    abstract protected function deleteAllApiKeys(): void;

    // </editor-fold>

    // <editor-fold desc="deleteApiKey">

    public function testDeleteApiKey(): void
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($apiKey);

        $response = $this->reportingCloud->deleteApiKey($apiKey);
        $this->assertTrue($response);
    }

    // </editor-fold>

    // <editor-fold desc="deleteTemplate">

    public function testDeleteTemplate(): void
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

    public function testDeleteTemplateInvalidTemplateName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $templateName = $this->getTestTemplateFilename();
        $this->reportingCloud->deleteTemplate($templateName);
    }

    public function testDeleteTemplateRuntimeException(): void
    {
        $this->expectException(RuntimeException::class);

        $this->reportingCloud->deleteTemplate('invalid-template.tx');
    }

    // </editor-fold>
}
