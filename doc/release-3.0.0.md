![Logo](../resource/rc_logo_512.png)

# ReportingCloud PHP SDK 3.0

## Introduction

This is the third major version since the release of the SDK in May 2016. 

**This version adds support for PHP 8.0 and improves the security and code quality of the SDK.**

## Notable Changes

### Added Support for PHP 8.0

ReportingCloud PHP SDK 3.0 is fully tested on PHP 8.0.

### Upgraded Minimum PHP Requirement to 7.4

ReportingCloud PHP SDK 3.0 requires PHP 7.4 or newer in order to be installed. 

If you are using an earlier version of PHP, you may continue using using ReportingCloud PHP SDK 2.0, which supports PHP 7.1, or ReportingCloud PHP SDK 1.0, which supports PHP 5.6. Note however, that new backend features will only be added to the most current version of the SDK.

### Added Typed Properties

One of most discussed new features of PHP 7.4 was [typed properties](https://stitcher.io/blog/typed-properties-in-php-74). ReportingCloud PHP SDK 3.0 now uses typed properties in all classes, resulting in improved security and code quality.

### Removed Nullable Type From Public Method Parameters

Since migrating to strict types and typed properties, it makes sense to disallow `null` in public method signatures. 

Consider the following example:

#### Old Function Signature

    public function mergeDocument(
        array   $mergeData,
        string  $returnFormat,
        ?string $templateName     = null,
        ?string $templateFilename = null,
        ?bool   $append           = null,
        ?array  $mergeSettings    = null
    ): array { }

#### New Function Signature

    public function mergeDocument(
        array  $mergeData,
        string $returnFormat,
        string $templateName     = '',      /* 3rd parameter */
        string $templateFilename = '',      /* 4th parameter */
        bool   $append           = false,   /* 5th parameter */
        array  $mergeSettings    = []       /* 6th parameter */
    ): array { }

Here the 3rd, 4th, 5th and 6th parameters have an empty value or false as default and not `null`.

You will only be affected by this change, if you have explicitly set `null` as a default value in your application code. In this case, you will see the following error when running your unit tests:

    PHP Fatal error:  Uncaught TypeError: 
    Argument 3 passed to TxTextControl\ReportingCloud\ReportingCloud::mergeDocument() 
    must be of the type string, null given, called in [..]

All you have to do is replace the `null` with the correct value (`''`, `[]`, `0` or `true|false`).

The above example shows just the `mergeDocument()` method signature, however this change affects all public methods.

### Update to Guzzle 7.0

At the request of several users – in particular, those those from the Laravel community – the SDK now uses [Guzzle 7.0](https://laravel-news.com/guzzle-7-released).

### Updated to PHPUnit 9.5

The SDK now uses PHPUnit 9.5 for unit tests.

### Removed class `StatusCode`

Versions prior to ReportingCloud PHP SDK 3.0 shipped with `TxTextControl\ReportingCloud\StatusCode\StatusCode`, which offered an abstraction to HTTP status codes. This class has been removed in favor of the package `ctw/ctw-http`. `ctw/ctw-http` offers all the functionality of the `StatusCode` class.

### PHPStan for Static Analysis

ReportingCloud PHP SDK 2.0 used three static analysis tools to check the code quality:

- [PHPStan](https://github.com/phpstan/phpstan)
- [Psalm](https://psalm.dev)
- [Phan](https://github.com/phan/phan)

ReportingCloud PHP SDK 3.0 uses just PHPStan, with the [strict rules](https://github.com/phpstan/phpstan-strict-rules) enabled.

### Deprecated Username and Password Authentication

The backend allows authentication via username and password or [API key](https://docs.reporting.cloud/docs/chapter/introduction/apikey). The former has been deprecated:

#### Deprecated Properties

```
ReportingCloud->username;
ReportingCloud->password;
```

#### Deprecated Methods

```
ReportingCloud->setUsername(string $username): self
ReportingCloud->getUsername(): string
```

```
ReportingCloud->setPassword(string $username): self
ReportingCloud->getPassword(): string
```

All the demos have been updated to use the API key authentication method.

Please updated your code to use the [API key](https://docs.reporting.cloud/docs/chapter/introduction/apikey) authentication method in due course.

The above properties and methods are marked with a `@deprecated` tag and will be removed in the next major version.

## Need Help?

The ReportingCloud PHP SDK is authored and supported by Text Control GmbH, the manufacturer of the ReportingCloud Web API.

Despite our best efforts to create understandable documentation, demo applications and unit tests, we understand that there are times when you may need some technical assistance.

If you have a question about ReportingCloud or the PHP SDK, we want to help you.

Please refer to the [Getting Support](https://docs.reporting.cloud/docs/chapter/introduction/support) section of the ReportingCloud [documentation](https://docs.reporting.cloud/) to learn more about the support channels at your disposition.
