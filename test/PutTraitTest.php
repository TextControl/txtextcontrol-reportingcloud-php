<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud;

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
