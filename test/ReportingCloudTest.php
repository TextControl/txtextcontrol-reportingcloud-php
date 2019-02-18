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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;

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

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAuthenticationWithEmptyCredentials(): void
    {
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
        $this->assertNotEmpty($apiKey);

        $reportingCloud2 = new ReportingCloud();

        $reportingCloud2->setTest(true);
        $reportingCloud2->setApiKey($apiKey);

        $this->assertEquals($apiKey, $reportingCloud2->getApiKey());
        $this->assertContains('Times New Roman', $reportingCloud2->getFontList());

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

        $this->assertSame('phpunit-username', $reportingCloud->getUsername());
        $this->assertSame('phpunit-password', $reportingCloud->getPassword());
        $this->assertSame('https://api.example.com', $reportingCloud->getBaseUri());
        $this->assertSame(100, $reportingCloud->getTimeout());
        $this->assertSame('v1', $reportingCloud->getVersion());

        $this->assertTrue($reportingCloud->getDebug());
        $this->assertTrue($reportingCloud->getTest());

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

        $this->assertSame('phpunit-username', $this->reportingCloud->getUsername());
        $this->assertSame('phpunit-password', $this->reportingCloud->getPassword());
        $this->assertSame('https://api.example.com', $this->reportingCloud->getBaseUri());
        $this->assertSame(100, $this->reportingCloud->getTimeout());
        $this->assertSame('v1', $this->reportingCloud->getVersion());

        $this->assertTrue($this->reportingCloud->getDebug());
        $this->assertTrue($this->reportingCloud->getTest());
    }

    public function testGetClientInstanceOf(): void
    {
        $this->assertInstanceOf('GuzzleHttp\Client', $this->reportingCloud->getClient());
    }

    public function testGetClientWithUsernameAndPassword(): void
    {
        $this->reportingCloud->setApiKey('');
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');

        $this->assertInstanceOf('GuzzleHttp\Client', $this->reportingCloud->getClient());
    }

    public function testDefaultProperties(): void
    {
        $reportingCloud = new ReportingCloud();

        $this->assertEmpty($reportingCloud->getUsername());
        $this->assertEmpty($reportingCloud->getPassword());

        $this->assertSame('https://api.reporting.cloud', $reportingCloud->getBaseUri());
        $this->assertSame(120, $reportingCloud->getTimeout());
        $this->assertSame('v1', $reportingCloud->getVersion());

        $this->assertFalse($reportingCloud->getDebug());

        unset($reportingCloud);
    }

    public function testResponseStatusCodeWithHttp(): void
    {
        $baseUri     = (string) $this->reportingCloud->getBaseUri();
        $this->assertNotEmpty($baseUri);

        $baseUriHost = parse_url($baseUri, PHP_URL_HOST);

        $this->assertNotEmpty($baseUriHost);

        $uri = sprintf('http://%s', $baseUriHost);

        try {
            $client = new Client();
            $client->request('GET', $uri);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response instanceof ResponseInterface) {
                $this->assertSame(404, $response->getStatusCode());
            }
        }
    }
}
