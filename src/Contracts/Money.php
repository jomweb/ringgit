<?php

namespace Duit\Contracts;

interface Money
{
    /**
     * Returns the value represented by this object.
     *
     * @return string
     */
    public function getAmount(): string;

    /**
     * Get the money currency.
     *
     * @return \Money\Currency
     */
    public function getCurrency(): \Money\Currency;

    /**
     * Get the money object.
     *
     * @return \Money\Money
     */
    public function getMoney(): \Money\Money;
}
