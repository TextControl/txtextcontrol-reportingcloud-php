<?php
declare(strict_types=1);

/**
 * ReportingCloud PHP Wrapper
 *
 * PHP wrapper for ReportingCloud Web API. Authored and supported by Text Control GmbH.
 *
 * @link      https://www.reporting.cloud to learn more about ReportingCloud
 * @link      https://github.com/TextControl/txtextcontrol-reportingcloud-php for the canonical source repository
 * @license   https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/LICENSE.md
 * @copyright © 2019 Text Control GmbH
 */

namespace TxTextControlTest\ReportingCloud;

/**
 * Trait PutTraitTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
trait PutTraitTest
{
    // <editor-fold desc="createApiKey">

    public function testCreateApiKey()
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($apiKey);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testCreateApiKeyTooManyApiKeys()
    {
        $this->deleteAllApiKeys();

        // only 10 API keys are allowed
        for ($i = 1; $i <= 11; $i++) {
            $this->assertNotEmpty($this->reportingCloud->createApiKey());
        }
    }

    // </editor-fold>
}
