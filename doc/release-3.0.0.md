![Logo](../resource/rc_logo_512.png)

# ReportingCloud PHP SDK 3.0

## Introduction

This is the new second major version since the release of the wrapper in May 2016.

This version does not add any new functionality on the backend, but does improve the quality of the code in the SDK.

## Notable Changes

The ReportingCloud PHP SDK 3.0

### Upgraded Minimum PHP Requirement to 7.3

### Added Typed Properties

### Updated to Guzzle 7.0

### Updated to PHPUnit 9.5

### Removed `StatusCode`

`TxTextControl\ReportingCloud\StatusCode\StatusCode` was replaced by the package `ctw/ctw-http`. 

### Standardized on PHPStan for Static Analysis

In ReportingCloud PHP SDK 2.0, three static analysis tools were configured to check the quality of the code. Since then PHPStan has gained much traction and has become the standard static analysis tool for this project. In particular, the [strict rules](https://github.com/phpstan/phpstan-strict-rules) have been applied.
