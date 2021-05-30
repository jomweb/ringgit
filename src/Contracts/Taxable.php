<?php

namespace Duit\Contracts;

use Money\Money as MoneyContract;

interface Taxable
{
    /**
     * Get tax percentage.
     */
    public function getAmountWithoutTax(MoneyContract $money): string;

    /**
     * Get tax percentage.
     */
    public function getAmountWithTax(MoneyContract $money): string;

    /**
     * Get tax percentage.
     */
    public function getTaxAmount(MoneyContract $money): string;

    /**
     * Tax code.
     */
    public function taxCode(): ?string;

    /**
     * Tax percentage.
     */
    public function taxRate(): float;
}
