<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use TxTextControl\ReportingCloud\Exception\InvalidArgumentException;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;

class ReportingCloudTest extends AbstractReportingCloudTest
{
    use DeleteTraitTest;
    use GetTraitTest;
    use PostTraitTest;
    use PutTraitTest;

    protected $reportingCloud;

    public function setUp()
    {
        $this->assertNotEmpty(ConsoleUtils::apiKey());

        $this->reportingCloud = new ReportingCloud();
        $this->reportingCloud->setApiKey(ConsoleUtils::apiKey());
    }

    public function tearDown()
    {
        unset($this->reportingCloud);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAuthenticationWithEmptyCredentials()
    {
        $reportingCloud = new ReportingCloud();

        $reportingCloud->setUsername('');
        $reportingCloud->setPassword('');
        $reportingCloud->setApiKey('');

        $reportingCloud->getFontList();
    }

    public function testAuthenticationWithApiKey()
    {
        $this->deleteAllApiKeys();

        $apiKey = $this->reportingCloud->createApiKey();
        $this->assertNotEmpty($apiKey);

        unset($this->reportingCloud);

        $reportingCloud = new ReportingCloud();

        $reportingCloud->setTest(true);
        $reportingCloud->setApiKey($apiKey);

        $this->assertEquals($apiKey, $reportingCloud->getApiKey());
        $this->assertContains('Times New Roman', $reportingCloud->getFontList());

        $this->deleteAllApiKeys();

        unset($reportingCloud);
    }

    public function testConstructorOptions()
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

    public function testSetGetProperties()
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

    public function testGetClientInstanceOf()
    {
        $this->assertInstanceOf('GuzzleHttp\Client', $this->reportingCloud->getClient());
    }

    public function testGetClientWithUsernameAndPassword()
    {
        $this->reportingCloud->setApiKey('');
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');

        $this->assertInstanceOf('GuzzleHttp\Client', $this->reportingCloud->getClient());
    }

    public function testDefaultProperties()
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

    public function testResponseStatusCodeWithHttp()
    {
        $baseUriHost = parse_url($this->reportingCloud->getBaseUri(), PHP_URL_HOST);

        $this->assertNotEmpty($baseUriHost);

        $uri = sprintf('http://%s', $baseUriHost);

        try {
            $client = new Client();
            $client->request('GET', $uri);
        } catch (ClientException $e) {
            $this->assertSame(404, $e->getResponse()->getStatusCode());
        }
    }
}
