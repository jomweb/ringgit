<?php

namespace Duit;

use Money\Money;

abstract class Taxable implements Contracts\Taxable
{
    /**
     * Tax code.
     *
     * @var string
     */
    protected $taxCode;

    /**
     * Tax rate percentage.
     *
     * @var int
     */
    protected $taxRate = 0;

    /**
     * Get tax percentage.
     *
     * @param \Money\Money $money
     */
    public function getAmountWithoutTax(Money $money): string
    {
        return $money->divide(1 + $this->taxRate())->getAmount();
    }

    /**
     * Get tax percentage.
     *
     * @param \Money\Money $money
     *
     * @return string
     */
    public function getAmountWithTax(Money $money): string
    {
        return $money->multiply(1 + $this->taxRate())->getAmount();
    }

    /**
     * Get tax percentage.
     *
     * @param \Money\Money $money
     *
     * @return string
     */
    public function getTaxAmount(Money $money): string
    {
        return $money->multiply($this->taxRate())->getAmount();
    }

    /**
     * Tax code.
     *
     * @return string
     */
    public function taxCode(): string
    {
        return $this->taxCode;
    }

    /**
     * Tax percentage.
     *
     * @return float
     */
    public function taxRate(): float
    {
        return round($this->taxRate / 100, 2);
    }
}
