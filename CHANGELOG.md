![Logo](https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/media/rc_logo_512.png)

# CHANGELOG

## dev-master

* Abstracted all parameter validation to `\TxTextControl\ReportingCloud\Validator\StaticValidator` 
* Made `\TxTextControl\ReportingCloud\Validator` properties consistent.

## 1.0.7 - 2016-06-08

* Made `\TxTextControl\ReportingCloud\Validator` properties consistent with those in `\Zend\Validator`.
* Updated `composer.json` to be installable on PHP 7.0.7.
* Improved date/time conversion `Filter` components.
* Added empty `CONTRIBUTING.md` file.
* Documentation update.
* Switched from `dump()` to `var_dump()` in `/demo` directory, as `symfony/var-dumper` is a development dependency only.
* Abstracted all date/time conversion to their own Filter components.

## 1.0.6 - 2016-06-02

* Documentation fixes.
* Added validation of file extension to all occurrences of `$templateFilename` and `$documentFilename`.

## 1.0.5 - 2016-06-01

* Documentation fixes.

## 1.0.4 - 2016-06-01

* First public release.

## 1.0.3 - 2016-06-01

* Implemented end-point `/v1/templates/pagecount`.
* Implemented end-point `/v1/templates/exists`.

## 1.0.2 - 2016-05-30

* Added `size` key to templateList.

## 1.0.1 - 2016-05-29

* Private testing only.

## 0.9.0 - 2016-05-27

* Private testing only.
