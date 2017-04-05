![Logo](./media/rc_logo_512.png)

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


## Install Using Composer

The recommended way to install the ReportingCloud PHP wrapper in your project is using [Composer](http://getcomposer.org):

```bash
composer require textcontrol/txtextcontrol-reportingcloud
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


## Username and Password for Demos and Unit Tests

The ReportingCloud PHP wrapper ships with a number of sample applications (see directory `/demo`) and phpunit tests (see directory `/test`). The scripts in each of these directories require a username and password for ReportingCloud in order to be executed. So that your username and password are not made inadvertently publicly available via a public GIT repository, you will first need to specify them. There are two ways in which you can do this:

### Using PHP Constants:

```php
define('REPORTING_CLOUD_USERNAME', 'your-username');
define('REPORTING_CLOUD_PASSWORD', 'your-password');
```

### Using Environmental Variables (For Example in `.bashrc`)

```bash
export REPORTING_CLOUD_USERNAME='your-username'
export REPORTING_CLOUD_PASSWORD='your-password'
```

Note, these instructions apply only to the sample applications and phpunit tests. When you use ReportingCloud in your application, set the username and password in your constructor or using the `setUsername($username)` and `setPassword($password)` methods. For an example of this case, see `/demo/instantiation.php`.


## Getting Started

As mentioned above, the ReportingCloud PHP wrapper ships with a number of sample applications (see directory `/demo`). These samples applications, which are well commented, have been written to demonstrate all parts of ReportingCloud.

We are currently working on comprehensive documentation for the ReportingCloud PHP wrapper, which will be published in the `/docs` directory, as and when it becomes available. In the meantime, please review the [Text Control Blog](http://www.textcontrol.com/en_US/blog/tags/reportingcloud/) , which contains many articles about ReportingCloud. 