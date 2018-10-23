![Logo](./data/rc_logo_512.png)

# ReportingCloud PHP Wrapper

[![Build Status](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/textcontrol/txtextcontrol-reportingcloud/v/stable)](https://packagist.org/packages/textcontrol/txtextcontrol-reportingcloud)
[![composer.lock available](https://poser.pugx.org/textcontrol/txtextcontrol-reportingcloud/composerlock)](https://packagist.org/packages/textcontrol/txtextcontrol-reportingcloud)

This is the official PHP wrapper for ReportingCloud Web API. It is authored and supported by [Text Control GmbH](http://www.textcontrol.com).

Learn more about ReportingCloud at:
 
* [ReportingCloud web site](http://www.reporting.cloud/)
 
* [ReportingCloud portal](https://portal.reporting.cloud/) - sign up here  

* [ReportingCloud Web API documentation](https://portal.reporting.cloud/Documentation/Reference/)

* [ReportingCloud PHP wrapper Packagist page](https://packagist.org/packages/textcontrol/txtextcontrol-reportingcloud)

* [ReportingCloud PHP wrapper GitHub page](https://github.com/TextControl/txtextcontrol-reportingcloud-php)

* [ReportingCloud PHP wrapper support](https://support.textcontrol.com/new-ticket)


## Minimum Requirements

The ReportingCloud PHP wrapper requires **PHP 5.6** or newer. There are two technical reasons for this:

* All versions of PHP prior to PHP 5.6 have reached [end-of-life](http://php.net/eol.php) and should thus not be used in a production environment.

* The dependencies [zendframework/zend-filter](https://packagist.org/packages/zendframework/zend-filter) and [zendframework/zend-validator](https://packagist.org/packages/zendframework/zend-validator) require PHP 5.6 or newer.

If your application is running in an older environment, it is highly advisable to update to a more current version of PHP.

If you are unable or unwilling to update your PHP installation, it is possible to use ReportingCloud by directly accessing the [Web API](https://portal.reporting.cloud/Documentation/Reference/) without using this wrapper. In such cases, it is advisable to use the [curl](http://php.net/manual/en/book.curl.php) extension to make the API calls.


## Install Using Composer

The recommended way to install the ReportingCloud PHP wrapper in your project is using [Composer](http://getcomposer.org):

```bash
composer require textcontrol/txtextcontrol-reportingcloud:^1.0
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update the ReportingCloud PHP wrapper using Composer:

```bash
composer update
```

and for best auto-loading performance consequently execute:

```bash
composer dump-autoload --optimize
```


## API Key for Demos and Unit Tests

The ReportingCloud PHP wrapper ships with a number of sample applications (see directory `/demo`) and phpunit tests (see directory `/test`). The scripts in each of these directories require an API key for ReportingCloud in order to be executed. So that the API key is not made inadvertently publicly available via a public GIT repository, you will first need to specify it. There are two ways in which you can do this:

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

As mentioned above, the ReportingCloud PHP wrapper ships with a number of sample applications (see directory `/demo`). These samples applications, which are well commented, have been written to demonstrate all parts of ReportingCloud.

We are currently working on comprehensive documentation for the ReportingCloud PHP wrapper, which will be published in the `/doc` directory, as and when it becomes available. In the meantime, please review the [Text Control Blog](https://www.textcontrol.com/blog/tag/reportingcloud/2018/) , which contains many articles about ReportingCloud.
 
 
 ## Getting Support
 
 The official PHP wrapper for ReportingCloud Web API is supported by Text Control GmbH. To start a conversation with the PHP people in the ReportingCloud Support Department, please [create a ticket](https://support.textcontrol.com/new-ticket), selecting _ReportingCloud_ from the department selection list.
 
 
 
