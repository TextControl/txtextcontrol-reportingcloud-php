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

        $this->assertEquals('phpunit-username'       , $reportingCloud->getUsername());
        $this->assertEquals('phpunit-password'       , $reportingCloud->getPassword());
        $this->assertEquals('https://api.example.com', $reportingCloud->getBaseUri());
        $this->assertEquals(100                      , $reportingCloud->getTimeout());
        $this->assertEquals('v1'                     , $reportingCloud->getVersion());

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

        $this->assertEquals('phpunit-username'       , $this->reportingCloud->getUsername());
        $this->assertEquals('phpunit-password'       , $this->reportingCloud->getPassword());
        $this->assertEquals('https://api.example.com', $this->reportingCloud->getBaseUri());
        $this->assertEquals(100                      , $this->reportingCloud->getTimeout());
        $this->assertEquals('v1'                     , $this->reportingCloud->getVersion());

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

        $this->assertEquals('https://api.reporting.cloud', $this->reportingCloud->getBaseUri());
        $this->assertEquals(120                          , $this->reportingCloud->getTimeout());
        $this->assertEquals('v1'                         , $this->reportingCloud->getVersion());

        $this->assertFalse($this->reportingCloud->getDebug());
    }

}
