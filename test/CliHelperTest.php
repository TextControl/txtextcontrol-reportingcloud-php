<?php

namespace TxTextControlTest\ReportingCloud;

use PHPUnit_Framework_TestCase;
use TxTextControl\ReportingCloud\CliHelper as Helper;

class CliHelperTest extends PHPUnit_Framework_TestCase
{

    public function testUsernameSetAsPhpConstant()
    {
        if (defined('REPORTING_CLOUD_USERNAME')) {
            $this->assertSame(REPORTING_CLOUD_USERNAME, Helper::username());
        }
    }

    public function testPasswordSetAsPhpConstant()
    {
        if (defined('REPORTING_CLOUD_PASSWORD')) {
            $this->assertSame(REPORTING_CLOUD_PASSWORD, Helper::password());
        }
    }

    public function testUsernameSetAsEnvironmentalVariable()
    {
        $key   = 'REPORTING_CLOUD_USERNAME';
        $value = 'phpunit-username';

        $_value = getenv($key);

        putenv("{$key}={$value}");

        $this->assertSame($value, Helper::username());

        if (!empty($_value)) {
            putenv("{$key}={$_value}");
        }
    }

    public function testPasswordSetAsEnvironmentalVariable()
    {
        $key   = 'REPORTING_CLOUD_PASSWORD';
        $value = 'phpunit-password';

        $_value = getenv($key);

        putenv("{$key}={$value}");

        $this->assertSame($value, Helper::password());

        if (!empty($_value)) {
            putenv("{$key}={$_value}");
        }
    }

    public function testErrorMessage()
    {
        $this->assertContains('Error: ReportingCloud username and/or password not defined', Helper::errorMessage());
    }

}
