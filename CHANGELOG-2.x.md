# Changelog for v2.x

This changelog references the relevant changes (bug and security fixes) done to `jomweb/ringgit`.

## 2.0.0

Released: 2018-06-01

### Added

* Added option to use SST type tax.

### Changes

* Increase minimum PHP to `v7.1.x`.
* Make `Duit\Concerns\Gst` optional.

### Removed

* Deprecate and remove `Duit\Concerns\Vat`, replaced with `Duit\Concerns\Tax`.
