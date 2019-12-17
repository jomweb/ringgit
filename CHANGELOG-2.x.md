# Changelog for v2.x

This changelog references the relevant changes (bug and security fixes) done to `jomweb/ringgit`.

## 2.2.0

Released: 2019-12-17

### Changes

* Remove PHP 7.1 support.

## 2.1.1

Released: 2019-03-04

### Changes

* Improve performance by prefixing all global functions calls with `\` to skip the look up and resolve process and go straight to the global function.

## 2.1.0

Released: 2018-08-23

### Changes

* Allow `Duit\Taxable\Sst::$taxRate` to be configurable upon construction.

## 2.0.0

Released: 2018-06-01

### Added

* Added option to use SST type tax.

### Changes

* Increase minimum PHP to `v7.1.x`.
* Make `Duit\Concerns\Gst` optional.

### Removed

* Deprecate and remove `Duit\Concerns\Vat`, replaced with `Duit\Concerns\Tax`.
