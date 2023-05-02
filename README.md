Malaysia Ringgit implementation on top of Money PHP
==============

[![tests](https://github.com/jomweb/ringgit/workflows/tests/badge.svg?branch=3.x)](https://github.com/jomweb/ringgit/actions?query=workflow%3Atests+branch%3A3.x)
[![Latest Stable Version](https://poser.pugx.org/jomweb/ringgit/v/stable)](https://packagist.org/packages/jomweb/ringgit)
[![Total Downloads](https://poser.pugx.org/jomweb/ringgit/downloads)](https://packagist.org/packages/jomweb/ringgit)
[![Latest Unstable Version](https://poser.pugx.org/jomweb/ringgit/v/unstable)](https://packagist.org/packages/jomweb/ringgit)
[![License](https://poser.pugx.org/jomweb/ringgit/license)](https://packagist.org/packages/jomweb/ringgit)
[![Coverage Status](https://coveralls.io/repos/github/jomweb/ringgit/badge.svg?branch=3.x)](https://coveralls.io/github/jomweb/ringgit?branch=3.x)

PHP 8.0+ library to make working with money safer, easier, and fun for Malaysia Ringgit!

> "If I had a dime for every time I've seen someone use FLOAT to store currency, I'd have $999.997634" -- [Bill Karwin](https://twitter.com/billkarwin/status/347561901460447232)

In short: You shouldn't represent monetary values by a float. Wherever
you need to represent money, use this Money value object.

``` php
<?php

use Duit\MYR;

$fiveMyr = MYR::given(500);
$tenMyr = $fiveMyr->add($fiveMyr);

list($part1, $part2, $part3) = $tenMyr->allocate(array(1, 1, 1));
assert($part1->equals(MYR::given(334)));
assert($part2->equals(MYR::given(333)));
assert($part3->equals(MYR::given(333)));
```

* [Installation](#installation)
* [Usages](#usages)
    - [Taxes](#taxes)

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "jomweb/ringgit": "^2.0"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "jomweb/ringgit"

## Usages

### Taxes

#### GST Declaration

##### Without GST

Declaring Money (MYR) without GST (Zero).

```php
use Duit\MYR;

$money = new MYR(540);
$money = MYR::given(540);
$money = MYR::withoutGst(540);
$money = MYR::withoutTax(540);
```

##### Before GST

Declaring Money (MYR) before GST is applied.

```php
use Duit\MYR;
use Duit\Taxable\Gst\ZeroRate;
use Duit\Taxable\Gst\StandardRate;

$money = MYR::beforeGst(540);

$money = MYR::beforeTax(540, new StandardRate());
$money = MYR::beforeTax(540, new ZeroRate());

$money = MYR::given(540)->useGstStandardRate(); // 6%
$money = MYR::given(540)->useGstZeroRate(); // 0%

$money = MYR::given(540)->enableTax(new StandardRate());
$money = MYR::given(540)->enableTax(new ZeroRate());
```

##### After GST

Declaring Money (MYR) with GST amount.

```php
use Duit\MYR;
use Duit\Taxable\Gst\ZeroRate;
use Duit\Taxable\Gst\StandardRate;

$money = MYR::afterGst(530); // always going to use 6%

$money = MYR::afterTax(540, new StandardRate());
$money = MYR::afterTax(540, new ZeroRate());
```


#### SST Declaration

##### Without SST

Declaring Money (MYR) without GST (Zero).

```php
use Duit\MYR;

$money = new MYR(540);
$money = MYR::given(540);
$money = MYR::withoutTax(540);
```

##### Before SST

Declaring Money (MYR) before SST is applied.

```php
use Duit\MYR;
use Duit\Taxable\Sst;

$money = MYR::beforeTax(530, new Sst());

$money = MYR::given(530)->enableTax(new Sst());
```

##### After SST

Declaring Money (MYR) with SST tax.

```php
use Duit\MYR;
use Duit\Taxable\Sst;

$money = MYR::afterTax(530, new Sst());
```
