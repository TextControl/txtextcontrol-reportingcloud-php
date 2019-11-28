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

use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Exception\RuntimeException;

/**
 * Trait PutTraitTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait PutTraitTest
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
     *
     */
    abstract protected function deleteAllApiKeys(): void;

    // </editor-fold>

    // <editor-fold desc="createApiKey">

    public function testCreateApiKey(): void
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($apiKey);
    }

    public function testCreateApiKeyTooManyApiKeys(): void
    {
        $this->expectException(RuntimeException::class);

        $this->deleteAllApiKeys();

        // only 10 API keys are allowed
        for ($i = 1; $i <= 11; $i++) {
            $this->assertNotEmpty($this->reportingCloud->createApiKey());
        }
    }
    // </editor-fold>
}
