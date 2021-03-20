<?php

namespace Duit;

use Money\Money;
use InvalidArgumentException;

abstract class Taxable implements Contracts\Taxable
{
    /**
     * Tax code.
     *
     * @var string|null
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
     *
     * @return string
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
     * @return string|null
     */
    public function taxCode(): ?string
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
        return \round($this->taxRate / 100, 2);
    }

    /**
     * Validate tax rate.
     *
     * @param  int  $taxRate
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    protected function validateTaxRate(int $taxRate): void
    {
        if ($taxRate < 0 || $taxRate > 100) {
            throw new InvalidArgumentException('Tax rate should be between 0 and 100.');
        }
    }
}
