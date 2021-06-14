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

namespace TxTextControlTest\ReportingCloud;

use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use GuzzleHttp\Client;

/**
 * Class ReportingCloudTest
 *
 * @package TxTextControlTest\ReportingCloud
 * @author  Jonathan Maron (@JonathanMaron)
 */
class ReportingCloudTest extends AbstractReportingCloudTest
{
    use DeleteTraitTest;
    use GetTraitTest;
    use PostTraitTest;
    use PutTraitTest;

    public function testAuthenticationWithEmptyCredentials(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $reportingCloud = new ReportingCloud();

        $reportingCloud->setUsername('');
        $reportingCloud->setPassword('');
        $reportingCloud->setApiKey('');

        $reportingCloud->getFontList();
    }

    public function testAuthenticationWithApiKey(): void
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        self::assertNotEmpty($apiKey);

        $reportingCloud2 = new ReportingCloud();

        $reportingCloud2->setTest(true);
        $reportingCloud2->setApiKey($apiKey);

        self::assertEquals($apiKey, $reportingCloud2->getApiKey());
        self::assertContains('Times New Roman', $reportingCloud2->getFontList());

        $this->deleteAllApiKeys();

        unset($reportingCloud2);
    }

    public function testConstructorOptions(): void
    {
        $options = [
            'username' => 'phpunit-username',
            'password' => 'phpunit-password',
            'base_uri' => 'https://api.example.com',
            'timeout'  => 100,
            'version'  => 'v1',
            'debug'    => true,
            'test'     => true,
        ];

        $reportingCloud = new ReportingCloud($options);

        self::assertSame('phpunit-username', $reportingCloud->getUsername());
        self::assertSame('phpunit-password', $reportingCloud->getPassword());
        self::assertSame('https://api.example.com', $reportingCloud->getBaseUri());
        self::assertSame(100, $reportingCloud->getTimeout());
        self::assertSame('v1', $reportingCloud->getVersion());

        self::assertTrue($reportingCloud->getDebug());
        self::assertTrue($reportingCloud->getTest());

        unset($reportingCloud);
    }

    public function testSetGetProperties(): void
    {
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');
        $this->reportingCloud->setBaseUri('https://api.example.com');
        $this->reportingCloud->setTimeout(100);
        $this->reportingCloud->setVersion('v1');
        $this->reportingCloud->setDebug(true);
        $this->reportingCloud->setTest(true);

        self::assertSame('phpunit-username', $this->reportingCloud->getUsername());
        self::assertSame('phpunit-password', $this->reportingCloud->getPassword());
        self::assertSame('https://api.example.com', $this->reportingCloud->getBaseUri());
        self::assertSame(100, $this->reportingCloud->getTimeout());
        self::assertSame('v1', $this->reportingCloud->getVersion());

        self::assertTrue($this->reportingCloud->getDebug());
        self::assertTrue($this->reportingCloud->getTest());
    }

    public function testGetClientInstanceOf(): void
    {
        self::assertInstanceOf(Client::class, $this->reportingCloud->getClient());
    }

    public function testGetClientWithUsernameAndPassword(): void
    {
        $this->reportingCloud->setApiKey('');
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');

        self::assertInstanceOf(Client::class, $this->reportingCloud->getClient());
    }

    public function testDefaultProperties(): void
    {
        $reportingCloud = new ReportingCloud();

        self::assertEmpty($reportingCloud->getUsername());
        self::assertEmpty($reportingCloud->getPassword());

        $envVarName = ConsoleUtils::BASE_URI;
        $baseUri    = getenv($envVarName);
        if (is_string($baseUri) && strlen($baseUri) > 0) {
            $expected = $baseUri;
        } else {
            $expected = 'https://api.reporting.cloud';
        }
        self::assertSame($expected, $reportingCloud->getBaseUri());
        self::assertSame(120, $reportingCloud->getTimeout());
        self::assertSame('v1', $reportingCloud->getVersion());

        self::assertFalse($reportingCloud->getDebug());

        unset($reportingCloud);
    }

    public function testGetBaseUriFromEnvVar(): void
    {
        $baseUri = ConsoleUtils::baseUri();

        if (is_string($baseUri) && strlen($baseUri) > 0) {
            $reportingCloud = new ReportingCloud();
            self::assertSame($baseUri, $reportingCloud->getBaseUri());
            unset($reportingCloud);
        }
    }

    public function testGetBaseUriFromEnvVarWithNull(): void
    {
        $envVarName = ConsoleUtils::BASE_URI;
        $baseUri    = getenv($envVarName);

        putenv("{$envVarName}");

        $reportingCloud = new ReportingCloud();
        self::assertSame('https://api.reporting.cloud', $reportingCloud->getBaseUri());
        unset($reportingCloud);

        putenv("{$envVarName}={$baseUri}");
    }

    public function testGetBaseUriFromEnvVarWithEmptyValue(): void
    {
        $envVarName = ConsoleUtils::BASE_URI;
        $baseUri    = getenv($envVarName);

        putenv("{$envVarName}=");

        $reportingCloud = new ReportingCloud();
        self::assertSame('https://api.reporting.cloud', $reportingCloud->getBaseUri());
        unset($reportingCloud);

        putenv("{$envVarName}={$baseUri}");
    }

    public function testGetBaseUriFromEnvVarWithInvalidValue(): void
    {
        $envVarName = ConsoleUtils::BASE_URI;
        $baseUri    = getenv($envVarName);
        if (is_string($baseUri) && strlen($baseUri) > 0) {
            putenv("{$envVarName}=https://www.example.com");
            try {
                $reportingCloud = new ReportingCloud();
            } catch (InvalidArgumentException $e) {
                putenv("{$envVarName}={$baseUri}");
                $expected = 'Expected base URI to end in "api.reporting.cloud". Got "https://www.example.com"';
                self::assertSame($expected, $e->getMessage());
            }
            if (isset($reportingCloud)) {
                unset($reportingCloud);
            }
        }
    }
}
