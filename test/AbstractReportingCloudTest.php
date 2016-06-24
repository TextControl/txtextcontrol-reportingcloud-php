<?php

namespace TxTextControlTest\ReportingCloud;

use PHPUnit_Framework_TestCase;
use TxTextControlTest\ReportingCloud\TestAsset\ConcreteReportingCloud;

class AbstractReportingCloudTest extends PHPUnit_Framework_TestCase
{
    protected $reportingCloud;

    public function setUp()
    {
        $this->reportingCloud = new ConcreteReportingCloud();
    }

    public function testConstructorOptions()
    {
        $reportingCloud = new ConcreteReportingCloud([
            'username' => 'phpunit-username',
            'password' => 'phpunit-password',
            'base_uri' => 'https://api.example.com',
            'timeout'  => 100,
            'version'  => 'v1',
            'debug'    => true,
        ]);

        $this->assertSame('phpunit-username'       , $reportingCloud->getUsername());
        $this->assertSame('phpunit-password'       , $reportingCloud->getPassword());
        $this->assertSame('https://api.example.com', $reportingCloud->getBaseUri());
        $this->assertSame(100                      , $reportingCloud->getTimeout());
        $this->assertSame('v1'                     , $reportingCloud->getVersion());

        $this->assertTrue($reportingCloud->getDebug());

        unset($reportingCloud);
    }

    public function testSetGetProperties()
    {
        $this->reportingCloud->setUsername('phpunit-username');
        $this->reportingCloud->setPassword('phpunit-password');
        $this->reportingCloud->setBaseUri ('https://api.example.com');
        $this->reportingCloud->setTimeout (100);
        $this->reportingCloud->setVersion ('v1');
        $this->reportingCloud->setDebug   (true);

        $this->assertSame('phpunit-username'       , $this->reportingCloud->getUsername());
        $this->assertSame('phpunit-password'       , $this->reportingCloud->getPassword());
        $this->assertSame('https://api.example.com', $this->reportingCloud->getBaseUri());
        $this->assertSame(100                      , $this->reportingCloud->getTimeout());
        $this->assertSame('v1'                     , $this->reportingCloud->getVersion());

        $this->assertTrue($this->reportingCloud->getDebug());
    }

    public function testGetClientInstanceOf()
    {
        $this->assertInstanceOf('GuzzleHttp\Client', $this->reportingCloud->getClient());
    }

    public function testDefaultProperties()
    {
        $this->assertNull($this->reportingCloud->getUsername());
        $this->assertNull($this->reportingCloud->getPassword());

        $this->assertSame('https://api.reporting.cloud', $this->reportingCloud->getBaseUri());
        $this->assertSame(120                          , $this->reportingCloud->getTimeout());
        $this->assertSame('v1'                         , $this->reportingCloud->getVersion());

        $this->assertFalse($this->reportingCloud->getDebug());
    }

    public function testHttp404IsReturnedOnHttp()
    {
        $baseUriHost = parse_url($this->reportingCloud->getBaseUri(), PHP_URL_HOST);
        $baseUriHost = trim($baseUriHost);

        $this->assertNotEmpty($baseUriHost);

        $uri = sprintf('http://%s', $baseUriHost);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL           , $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER        , true);

        $response = curl_exec($ch);

        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header     = substr($response, 0, $headerSize);

        $this->assertContains('404 Not Found', $header);

    }

}
