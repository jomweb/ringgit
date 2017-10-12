Malaysia Ringgit implementation on top of Money PHP
==============

[![Build Status](https://travis-ci.org/jomweb/ringgit.svg?branch=master)](https://travis-ci.org/jomweb/ringgit)
[![Latest Stable Version](https://poser.pugx.org/jomweb/ringgit/v/stable)](https://packagist.org/packages/jomweb/ringgit)
[![Total Downloads](https://poser.pugx.org/jomweb/ringgit/downloads)](https://packagist.org/packages/jomweb/ringgit)
[![Latest Unstable Version](https://poser.pugx.org/jomweb/ringgit/v/unstable)](https://packagist.org/packages/jomweb/ringgit)
[![License](https://poser.pugx.org/jomweb/ringgit/license)](https://packagist.org/packages/jomweb/ringgit)


PHP 7.0+ library to make working with money safer, easier, and fun for Malaysia Ringgit!

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

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "jomweb/ringgit": "^1.0"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "jomweb/ringgit"

## Usages

### Declaration 

#### Without GST

Declaring Money (MYR) without GST (Zero).

```php
use Duit\MYR;

$money = new MYR(540);
$money = MYR::given(540);
$money = MYR::withoutVat(540);
$money = MYR::withoutGst(540);
```

#### Before GST

Declaring Money (MYR) before GST is applied.

```php
use Duit\MYR;

$money = MYR::beforeVat(540);
$money = MYR::beforeGst(540);
```

#### After GST

Declaring Money (MYR) with GST amount.

```php
use Duit\MYR;

$money = MYR::afterVat(530);
$money = MYR::afterGst(530);
```

