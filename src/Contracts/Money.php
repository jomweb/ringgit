<?php

namespace Duit\Contracts;

interface Money
{
    /**
     * Returns the value represented by this object.
     * 
     * @return numeric-string
     */
    public function getAmount(): string;

    /**
     * Get the money currency.
     */
    public function getCurrency(): \Money\Currency;

    /**
     * Get the money object.
     */
    public function getMoney(): \Money\Money;
}
