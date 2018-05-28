<?php

namespace Duit\Contracts;

use Money\Money as MoneyContract;

interface Taxable
{
    /**
     * Get tax percentage.
     *
     * @param \Money\Money $money
     */
    public function getAmountWithoutTax(MoneyContract $money): string;

    /**
     * Get tax percentage.
     *
     * @param \Money\Money $money
     *
     * @return string
     */
    public function getAmountWithTax(MoneyContract $money): string;

    /**
     * Get tax percentage.
     *
     * @param \Money\Money $money
     *
     * @return string
     */
    public function getTaxAmount(MoneyContract $money): string;

    /**
     * Tax code.
     *
     * @return string|null
     */
    public function taxCode(): ?string;

    /**
     * Tax percentage.
     *
     * @return float
     */
    public function taxRate(): float;
}
