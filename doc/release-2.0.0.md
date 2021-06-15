![Logo](../resource/rc_logo_512.png)

# ReportingCloud PHP SDK 2.0

## Introduction

This is the second major version since the release of the wrapper in May 2016.

## Notable Changes

### Removed All Zend Framework Dependencies

[Zend Framework](https://framework.zend.com/) (ZF) is an excellent framework for the development of robust business applications, and one that we -- at Text Control GmbH -- have been using since its original incarnation in 2006. We will continue to use ZF in other projects, but not in the ReportingCloud PHP SDK.

The ReportingCloud PHP SDK is just one component of a typical web application -- a minor component, it may be added. The fewer components that such a wrapper depends upon, the better.

For applications based on ZF3, the ReportingCloud PHP SDK 1.x had excellent integration. However, the problems (read "[dependency hell](https://en.wikipedia.org/wiki/Dependency_hell)") started when you tried to install the ReportingCloud PHP SDK 1.x into an older ZF2 or ZF1 application. In many cases, it was impossible due to conflicts in the required version of the ZF component [ServiceManager](https://github.com/zendframework/zend-servicemanager).

As a consequence, the ZF3 dependency in the ReportingCloud PHP SDK 1.x alienated all developers, maintaining older ZF applications.

Additionally, when using the PHP ReportingCloud Wrapper 1.x in an application not based on ZF -- for example, one based on Symfony, Laravel, or a home-grown framework, it seemed very wasteful pulling in all the dependent ZF components ([ServiceManager](https://github.com/zendframework/zend-servicemanager), [Stdlib](https://github.com/zendframework/zend-stdlib), [Validator](https://github.com/zendframework/zend-validator) and [Filter](https://github.com/zendframework/zend-filter)), just in order to use the ReportingCloud web service.

For these two reasons, the PHP ReportingCloud Wrapper 2.0 no longer depends upon ZF. The required validation functionality is provided by [Assert](https://github.com/webmozart/assert), which has no further dependencies and, in comparison to ZF, is extremely lightweight.

### Added Support for Laminas (formerly [Zend Framework 3](https://github.com/TextControl/txtextcontrol-reportingcloud-php-laminas-module/blob/master/doc/zend-framework.md))

Since the PHP ReportingCloud Wrapper is popular in the Laminas community, we do not want to alienate this group of developers. Therefore, if you are maintaining or planning a Laminas based application, take a look at the official [ReportingCloud Laminas Module](https://github.com/TextControl/txtextcontrol-reportingcloud-php-laminas-module). This Laminas module tightly integrates ReportingCloud into the Laminas [View](https://github.com/laminas/laminas-view) (as a View Helper) and [Mvc](https://github.com/laminas/laminas-mvc) (as a Controller Plugin) components. Furthermore, the ReportingCloud service can be accessed during dependency injection in the [ServiceManager](https://github.com/laminas/laminas-servicemanager).

### Increased Minimum PHP Version

All versions of PHPs prior to 7.1 have reached [end-of-life](http://php.net/eol.php) and therefore, no further security updates will be released for them. We moved the minimum PHP version to the oldest supported PHP version, namely 7.1, to ensure that the ReportingCloud PHP SDK can be installed in as many supported environments as possible:

| Wrapper Version                | Minimum PHP Version |
| ------------------------------ |:-------------------:|
| ReportingCloud PHP SDK 2.0 | PHP 7.1             |
| ReportingCloud PHP SDK 1.x | PHP 5.6             |

If you require support for PHP 5.6, consider updating your environment, or take a look at ReportingCloud PHP SDK 1.x.

Besides running faster than previous versions, PHP 7.1 offers [new features](http://php.net/manual/de/migration71.new-features.php), such as:

- Strict typing
- Constant visibility
- Multi catch exception handling
- Void functions
- Nullable types

The ReportingCloud PHP SDK 2.0 takes advantage of these new features to make the code shorter, securer and robuster.

### Moved All HTTP Response Codes to New Component

It is bad practice to place magic numbers in program code, and that goes for HTTP response codes too. In the ReportingCloud PHP SDK 2.0, all HTTP response codes, which are checked following every interaction with the backend server, have been abstracted to constants in `TxTextControl\ReportingCloud\StatusCode\StatusCode`. These constants are then used in the main program code.

### Moved String, Array and Console Utilities to New Component

Common functionality for handling strings, array and console interactions has been abstracted to a new component called `TxTextControl\ReportingCloud\Stdlib`.

### Updated to PHPUnit 7.5

The ReportingCloud PHP SDK has 100% test coverage, powered by PHPUnit. In version 2.0, we upgraded all unit tests to PHPUnit 7.5. We have tested in PHP 7.1, PHP 7.2 and PHP 7.3.
