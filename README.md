![Logo](./resource/rc_logo_512.png)

# ReportingCloud PHP SDK

[![Build Status](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/textcontrol/txtextcontrol-reportingcloud/v/stable)](https://packagist.org/packages/textcontrol/txtextcontrol-reportingcloud)
[![composer.lock available](https://poser.pugx.org/textcontrol/txtextcontrol-reportingcloud/composerlock)](https://packagist.org/packages/textcontrol/txtextcontrol-reportingcloud)

This is the official PHP SDK for ReportingCloud Web API. It is authored and supported by [Text Control GmbH](http://www.textcontrol.com).

Learn more about ReportingCloud at:

* [ReportingCloud web site](https://www.reporting.cloud/)

* [ReportingCloud portal](https://portal.reporting.cloud/) - sign up here

* [ReportingCloud documentation](https://docs.reporting.cloud/)

* [ReportingCloud PHP SDK Packagist page](https://packagist.org/packages/textcontrol/txtextcontrol-reportingcloud)

* [ReportingCloud PHP SDK GitHub page](https://github.com/TextControl/txtextcontrol-reportingcloud-php)

* [ReportingCloud PHP SDK API documentation](https://textcontrol.github.io/txtextcontrol-reportingcloud-php/docs-api/)

* [ReportingCloud PHP SDK support](https://docs.reporting.cloud/docs/chapter/introduction/support)

## Minimum Requirements

Since [ReportingCloud PHP SDK 2.0](/doc/release-2.0.0.md), the PHP SDK requires **PHP 7.1** or newer. 

All versions of PHPs prior to 7.1 have reached [end-of-life](http://php.net/eol.php) and consequently, no further security updates will be released for them. If your application is running in an older environment, it is highly advisable to update to a more current version of PHP.

If you are unable or unwilling to update your PHP installation, you may consider using the ReportingCloud PHP SDK 1.0, which supports PHP 5.6. Please note, however, this version is no longer maintained.

Alternatively, it possible to use ReportingCloud by directly accessing the [Web API](https://docs.reporting.cloud/docs/endpoint). In such cases, it is advisable to use the [curl](http://php.net/manual/en/book.curl.php) extension to make the API calls.


## Install Using Composer

Install the ReportingCloud PHP SDK in your project is using [Composer](http://getcomposer.org):

```bash
composer require textcontrol/txtextcontrol-reportingcloud:^2.0
```

After installing, you need to include Composer's autoloader:

```php
include_once 'vendor/autoload.php';
```

You can then later update the ReportingCloud PHP SDK using Composer:

```bash
composer update
```

and for best auto-loading performance consequently execute:

```bash
composer dump-autoload --optimize
```


## API Key for Demos and Unit Tests

The ReportingCloud PHP SDK ships with a number of sample applications (see directory `/demo`) and phpunit tests (see directory `/test`). The scripts in each of these directories require an [API key](https://docs.reporting.cloud/docs/chapter/introduction/apikey) for ReportingCloud in order to be executed. So that the API key is not made inadvertently publicly available via a public GIT repository, you will first need to specify it. There are two ways in which you can do this:

### Using PHP Constants:

```php
define('REPORTING_CLOUD_API_KEY', 'your-api-key');
```

### Using Environmental Variables (For Example in `.bashrc`)

```bash
export REPORTING_CLOUD_API_KEY='your-api-key'
```

Note, these instructions apply only to the demo scripts and phpunit tests. When you use ReportingCloud in your application, set the API key in your constructor or by using the `setApiKey($apiKey)` methods. For an example, see `/demo/instantiation.php`.


## Getting Started

The [PHP Quickstart Tutorial](https://docs.reporting.cloud/docs/chapter/quickstart/php) in the ReportingCloud [documentation](https://docs.reporting.cloud/) is your starting point to using the ReportingCloud PHP SDK in your own applications.

In addition, the ReportingCloud PHP SDK ships with a number of sample applications (see directory `/demo`). These samples applications, which are well commented, have been written to demonstrate all parts of ReportingCloud.

 ## Getting Support

The ReportingCloud PHP SDK is supported by Text Control GmbH.

Despite our best efforts to create understandable documentation, demo applications and unit tests, we understand that there are times when you may need some technical assistance.

If you have a question about ReportingCloud or the PHP SDK, we want to help you.

Please refer to the [Getting Support](https://docs.reporting.cloud/docs/chapter/introduction/support) section of the ReportingCloud [documentation](https://docs.reporting.cloud/) to learn more about the support channels at your disposition.


