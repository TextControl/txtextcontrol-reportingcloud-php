![Logo](../resource/rc_logo_512.png)

# ReportingCloud PHP SDK 3.0

## Introduction

This is the third major version since the release of the SDK in May 2016. This version does not add any new
functionality on the backend, but does improve the quality and security of the code in the SDK.

## Notable Changes

### Upgraded Minimum PHP Requirement to 7.4

ReportingCloud PHP SDK 3.0 requires PHP 7.4 or newer in order to be installed. If you are using an earlier version of
PHP, you may continue using using ReportingCloud PHP SDK 2.0, which supports PHP 7.1, or ReportingCloud PHP SDK 1.0,
which supports PHP 5.6. Note however, that new backend features will only be added to the most current version of the
SDK.

### Added Typed Properties

One of the new features of PHP 7.4 was [typed properties](https://stitcher.io/blog/typed-properties-in-php-74). The SDK
now uses typed properties in all classes, resulting in improved security and code quality.

### Updated to Guzzle 7.0

At the request of several users (especially those using Laravel), the SDK now
uses [Guzzle 7.0](https://laravel-news.com/guzzle-7-released).

### Updated to PHPUnit 9.5

The SDK now uses the PHPUnit 9.5, which at the time of writing, is the most current version.

### Removed class `StatusCode`

`TxTextControl\ReportingCloud\StatusCode\StatusCode` was replaced by the package `ctw/ctw-http`. `ctw/ctw-http` offers
all the functionality of the previous `StatusCode` class.

### PHPStan for Static Analysis

ReportingCloud PHP SDK 2.0 used the following static analysis tools to check the code quality:

- [PHPStan](https://github.com/phpstan/phpstan)
- [Psalm](https://psalm.dev)
- [Phan](https://github.com/phan/phan)

ReportingCloud PHP SDK 3.0 uses just PHPStan, with the [strict rules](https://github.com/phpstan/phpstan-strict-rules)
enabled.

### Deprecated Credentials Authentication

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

The above properties and methods are marked with a `@deprecated` tag and will be removed in the next major version.

Instead, please use the API key authentication method.

