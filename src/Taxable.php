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
     * @return numeric-string
     */
    public function getAmountWithoutTax(Money $money): string
    {
        return $money->divide((string) (1 + $this->taxRate()))->getAmount();
    }

    /**
     * Get tax percentage.
     * 
     * @return numeric-string
     */
    public function getAmountWithTax(Money $money): string
    {
        return $money->multiply((string) (1 + $this->taxRate()))->getAmount();
    }

    /**
     * Get tax percentage.
     * 
     * @return numeric-string
     */
    public function getTaxAmount(Money $money): string
    {
        return $money->multiply((string) $this->taxRate())->getAmount();
    }

    /**
     * Tax code.
     */
    public function taxCode(): ?string
    {
        return $this->taxCode;
    }

    /**
     * Tax percentage.
     */
    public function taxRate(): float
    {
        return round($this->taxRate / 100, 2);
    }

    /**
     * Validate tax rate.
     *
     * @throws \InvalidArgumentException
     */
    protected function validateTaxRate(int $taxRate): void
    {
        if ($taxRate < 0 || $taxRate > 100) {
            throw new InvalidArgumentException('Tax rate should be between 0 and 100.');
        }
    }
}
