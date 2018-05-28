<?php

namespace Duit\Concerns;

use Money\Money;
use Money\MoneyFormatter;

trait Vat
{
    use Cash;

    /**
     * Enable GST/VAL calculation.
     *
     * @var bool
     */
    protected $vat = false;

    /**
     * Make object with GST/VAT.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function afterVat($amount)
    {
        return static::beforeVat(
            static::asMoney($amount)->divide(1.06)->getAmount()
        );
    }

    /**
     * Make object without GST/VAT.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function withoutVat($amount)
    {
        return (new static($amount))->disableVat();
    }

    /**
     * Make object before applying GST/VAT.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function beforeVat($amount)
    {
        return (new static($amount))->enableVat();
    }

    /**
     * Get formatted amount with GST/VAT.
     *
     * @return string
     */
    public function amountWithVat(): string
    {
        return $this->getFormatter()->format(
            static::asMoney($this->getAmountWithVat())
        );
    }

    /**
     * Get formatted cash with GST/VAT.
     *
     * @return string
     */
    public function cashAmountWithVat(): string
    {
        return $this->getFormatter()->format(
            static::asMoney($this->getCashAmountWithVat())
        );
    }

    /**
     * Enable GST/VAT for calculation.
     *
     * @return $this
     */
    final public function enableVat(): self
    {
        $this->vat = true;

        return $this;
    }

    /**
     * Disable GST/VAT for calculation.
     *
     * @return $this
     */
    final public function disableVat(): self
    {
        $this->vat = false;

        return $this;
    }

    /**
     * Get GST/VAT amount.
     *
     * @return string
     */
    public function getVatAmount(): string
    {
        if (! $this->vat) {
            return '0';
        }

        return $this->getMoney()->multiply(0.06)->getAmount();
    }

    /**
     * Returns the value represented by this object with GST/VAT.
     *
     * @return string
     */
    public function getAmountWithVat(): string
    {
        if (! $this->vat) {
            return $this->getMoney()->getAmount();
        }

        return $this->getMoney()->multiply(1.06)->getAmount();
    }

    /**
     * Get amount for cash with GST/VAT.
     *
     * @return string
     */
    public function getCashAmountWithVat(): string
    {
        return (string) $this->getClosestAcceptedCashAmount(
            $this->getAmountWithVat()
        );
    }

    /**
     * Allocate the money according to a list of ratios with GST/VAT.
     *
     * @param  array  $ratios
     *
     * @return Money[]
     */
    public function allocateWithVat(array $ratios): array
    {
        $results = [];
        $allocates = static::asMoney($this->getAmountWithVat())->allocate($ratios);

        foreach ($allocates as $allocate) {
            $results[] = static::afterVat($allocate->getAmount());
        }

        return $results;
    }

    /**
     * Allocate the money among N targets with GST/VAT.
     *
     * @param  int  $n
     *
     * @throws \InvalidArgumentException If number of targets is not an integer
     *
     * @return Money[]
     */
    public function allocateWithVatTo(int $n): array
    {
        $results = [];
        $allocates = static::asMoney($this->getAmountWithVat())->allocateTo($n);

        foreach ($allocates as $allocate) {
            $results[] = static::afterVat($allocate->getAmount());
        }

        return $results;
    }

    /**
     * Get the money object.
     *
     * @return \Money\Money
     */
    abstract public function getMoney(): Money;

    /**
     * Build money object.
     *
     * @param  int|string  $amount
     *
     * @return \Money\Money
     */
    abstract protected static function asMoney($amount): Money;

    /**
     * Get money formatter.
     *
     * @return \Money\MoneyFormatter
     */
    abstract protected function getFormatter(): MoneyFormatter;
}
