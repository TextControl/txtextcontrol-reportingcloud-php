![Logo](../media/rc_logo_512.png)

# Why Was Travis Building Removed?

Since the original release of `txtextcontrol-reportingcloud-php`, there are been issues with TLS on Travis.

Specifically, the infamous error:

    cURL error 35: gnutls_handshake() failed: A TLS packet with unexpected length was received.

On July 18, 2016, the author of this library presented a workaround, which worked on PHP 5.5 only:

http://stackoverflow.com/questions/38375211/curl-error-35-gnutls-handshake-failed

Newer versions of `txtextcontrol-reportingcloud-php` require PHP 5.6 or newer. The above workaround therefore no longer works.

On April 5, 2017 the author tested the standard [5.6](https://travis-ci.org/TextControl/txtextcontrol-reportingcloud-php/jobs/218844575) and [7.0](https://travis-ci.org/TextControl/txtextcontrol-reportingcloud-php/jobs/218844576) versions of PHP and standard TLS library on Travis.

Unfortunately, the issue that is described in the above StackOverflow post persisted.

Therefore, it is with sadness that Travis Building was removed from `txtextcontrol-reportingcloud-php` on April 5, 2017.

The author of `txtextcontrol-reportingcloud-php` will review the TLS situation on Travis in the coming months, and if it improves, Travis Building will be re-enabled.

## What Are the Alternatives?

### Scrutinizer Building

Since the original release of `txtextcontrol-reportingcloud-php`, code quality information has been made available on Scrutinizer at:

https://scrutinizer-ci.com/g/TextControl/txtextcontrol-reportingcloud-php/

Since Scrutinizer runs the unit tests against PHP 5.6, which does not have the above described TLS issues, the build is successful on Scrutinizer.

To see the output from the unit tests go to:

    Inspections -> Build -> Log -> Tests -> ./vendor/phpunit/phpunit/phpunit

on the above Scrutinizer page.

### Run Unit Tests Locally

To run the unit tests yourself, simply call:

    ./vendor/phpunit/phpunit/phpunit
    
in the root directory of `txtextcontrol-reportingcloud-php`, after having specified your Reporting Cloud username and password.
