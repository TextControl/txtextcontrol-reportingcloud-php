![Logo](https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/media/rc_logo_512.png)

# ReportingCloud PHP Wrapper

[![Build Status](https://travis-ci.org/TextControl/txtextcontrol-reportingcloud-php.svg)](https://travis-ci.org/TextControl/txtextcontrol-reportingcloud-php)
[![Coverage Status](https://coveralls.io/repos/TextControl/txtextcontrol-reportingcloud-php/badge.svg?branch=master&service=github)](https://coveralls.io/github/TextControl/txtextcontrol-reportingcloud-php?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/textcontrol/txtextcontrol-reportingcloud/v/stable)](https://packagist.org/packages/textcontrol/txtextcontrol-reportingcloud)
[![composer.lock available](https://poser.pugx.org/textcontrol/txtextcontrol-reportingcloud/composerlock)](https://packagist.org/packages/textcontrol/txtextcontrol-reportingcloud)

This is the official PHP wrapper for ReportingCloud, which is authored, maintained and fully supported by [Text Control](http://www.textcontrol.com).

[http://www.reporting.cloud](http://www.reporting.cloud)

Before using ReportingCloud, please sign up to the service:

[http://portal.reporting.cloud](http://portal.reporting.cloud)


## Install using Composer

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


## Username and password for demos and unittests

The ReportingCloud PHP wrapper ships with a number of sample applications (see directory `/demo`) and phpunit tests (see directory `/test`). The scripts in each of these directories require a username and password for ReportingCloud in order to be executed. So that your username and password are not made inadvertently publicly available via a public GIT repository, you will first need to specify them. There are two ways in which you can do this:

### Using PHP constants:

```php
define('REPORTING_CLOUD_USERNAME', 'your-username');
define('REPORTING_CLOUD_PASSWORD', 'your-password');
```

### Using environmental variables (for example in `.bashrc`)

```bash
export REPORTING_CLOUD_USERNAME='your-username'
export REPORTING_CLOUD_PASSWORD='your-password'
```

Note, these instructions apply only to the sample applications and phpunit tests. When you use ReportingCloud in your application, set the username and password in your constructor or using the `setUsername($username)` and `setPassword($password)` methods. For an example of this case, see `demo/instantiation.php`.


## API documentation (phpdoc)

All the source code in this component library is documented using [phpDocumentor](https://www.phpdoc.org/).

You can read the [API documentation](https://textcontrol.github.io/txtextcontrol-reportingcloud-php/docs-api/) online, or build it yourself, using the following shell command:

```bash
phpdoc run --directory ./src --target ~/txtextcontrol-reportingcloud/src-docs --template clean
```

The resultant set of HTML files will be written to `~/txtextcontrol-reportingcloud/src-docs`.


## Unit tests with code coverage (phpunit)

100% unit test coverage is supplied by phpunit.

You can review the [code coverage report](https://textcontrol.github.io/txtextcontrol-reportingcloud-php/test-coverage/) online, or build it yourself, using the following shell command:

```bash
phpunit --coverage-html ~/txtextcontrol-reportingcloud/test-coverage
```

The resultant set of HTML files will be written to `~/txtextcontrol-reportingcloud/test-coverage`.


## Coding standards

This component library follows [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standards, and additionally:

* Uses lowercase underscore-separated keys names for associative arrays.
* Uses camelCase for namespaces, class, method and property names.

When contributing, please respect this standard with its two above mentioned additions.
