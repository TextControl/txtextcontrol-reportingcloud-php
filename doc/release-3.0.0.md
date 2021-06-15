![Logo](../resource/rc_logo_512.png)

# ReportingCloud PHP SDK 3.0

## Introduction

This is the third major version since the release of the SDK in May 2016. This version improves the security, performance and code quality of the SDK.

## Notable Changes

### Upgraded Minimum PHP Requirement to 7.4

ReportingCloud PHP SDK 3.0 requires PHP 7.4 or newer in order to be installed. If you are using an earlier version of PHP, you may continue using using ReportingCloud PHP SDK 2.0, which supports PHP 7.1, or ReportingCloud PHP SDK 1.0, which supports PHP 5.6. Note however, that new backend features will only be added to the most current version of the SDK.

### Added Typed Properties

One of most discussed new features of PHP 7.4 is [typed properties](https://stitcher.io/blog/typed-properties-in-php-74). ReportingCloud PHP SDK 3.0 now uses typed properties in all classes, resulting in improved security and code quality.

### Added Support for PHP 8.0

ReportingCloud PHP SDK 3.0 can now be installed on PHP 8.0 systems.

### Updated to Guzzle 7.0

At the request of several users (especially those from the Laravel community), the SDK now uses [Guzzle 7.0](https://laravel-news.com/guzzle-7-released).

### Updated to PHPUnit 9.5

The SDK now uses PHPUnit 9.5, which at the time of writing, is the most current version of PHPUnit.

### Removed class `StatusCode`

Versions prior to ReportingCloud PHP SDK 3.0 shipped with `TxTextControl\ReportingCloud\StatusCode\StatusCode`, which offered an abstraction to HTTP status codes. This class has been removed in favor of the package `ctw/ctw-http`. `ctw/ctw-http` offers all the functionality of the `StatusCode` class.

### PHPStan for Static Analysis

ReportingCloud PHP SDK 2.0 three static analysis tools to check the code quality:

- [PHPStan](https://github.com/phpstan/phpstan)
- [Psalm](https://psalm.dev)
- [Phan](https://github.com/phan/phan)

ReportingCloud PHP SDK 3.0 uses just PHPStan, with the [strict rules](https://github.com/phpstan/phpstan-strict-rules) enabled.

### Deprecated Username and Password Authentication

The backend allows authentication via username and password or API key. The former has been deprecated:

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

Please updated your code to use the API key authentication method in due course.

The above properties and methods are marked with a `@deprecated` tag and will be removed in the next major version.
