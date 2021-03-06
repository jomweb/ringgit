# Changelog for v1.x

This changelog references the relevant changes (bug and security fixes) done to `jomweb/ringgit`.

## 1.0.6

Released: 2018-05-29

### Fixes

* Fixes return value from `Duit\MYR::__call()` which isn't an instance of `Money\Money`.

## 1.0.5

Released: 2018-05-21

### Changes

* Improves forward compatibility for `Duit\MYR::parse()`.

## 1.0.4

Released: 2018-04-30

### Added

* Add `Duit\MYR::parse()` to parse value to money.

## 1.0.3

Released: 2018-04-03

### Fixes

* Fixes serialization to JSON.

## 1.0.2

Released: 2017-12-30

### Fixes

* Ensure any call going to `Money\Money` would be immutable to current instance.

## 1.0.1

Released: 2017-10-26

### Changes

* Add PHP 7 scalar typehint and return type.

## 1.0.0

Released: 2017-10-12

### New

* Initial stable release.
