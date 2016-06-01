![Logo](https://raw.githubusercontent.com/TextControl/ReportingCloud.PHP/master/resource/rc_logo_512.png)

#  ReportingCloud PHP Wrapper 1.0

This is the official PHP wrapper for ReportingCloud, which is authored, maintained and fully supported by [Text Control](http://www.textcontrol.com).

[http://www.reporting.cloud](http://www.reporting.cloud)

Before using ReportingCloud, please sign up to the service:

[http://api.reporting.cloud](http://api.reporting.cloud)


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


## Username and password for demos and unittests

The ReportingCloud PHP wrapper ships with a number of sample applications (see directory `/demo`) and phpunit tests (see directory `/test`). The scripts in each of these directories require a username and password for ReportingCloud in order to be executed. So that your username and password are not made inadvertently publicly available via a public GIT repository, you will first need to specify them. There are two ways in which you can do this:

### Using PHP constants:

```php
define('REPORTING_CLOUD_USERNAME', 'your-username');
define('REPORTING_CLOUD_PASSWORD', 'your-password');
```

### Using environmental variables (for example in .bashrc)

```bash
export REPORTING_CLOUD_USERNAME='your-username'
export REPORTING_CLOUD_PASSWORD='your-password'
```

Note, these instructions apply only to the sample applications and phpunit tests. When you use ReportingCloud in your application, set the username and password in your constructor or using the `setUsername($username)` and `setPassword($password)` methods. For an example of this case, see `demo/instantiation.php`.


## Documentation generation

All the source code in this component library is documented using [phpDocumentor](https://www.phpdoc.org/). To build the documentation, simply execute the following from the shell:

```bash
rm -fr ./src-docs && ./vendor/bin/phpdoc run --directory ./src --target ./src-docs --template clean
```

The resultant set of HTML files will be written to `/src-docs`.

*phpDocumentor* is installed as a development dependency by Composer.
 
 
## Unit tests

100% unit test coverage is supplied by phpunit. To run the unit tests and build its report, simply execute the following from the shell:

```bash
rm -fr ./test-coverage && phpunit
```

The resultant set of HTML files will be written to `/test-coverage`.

*phpunit* is installed as a development dependency by Composer.


## Coding standards

This component library follows PSR-2 coding standards (http://goo.gl/yM5Pe2), and additionally uses lowercase underscore separated keys names for associative arrays. 
