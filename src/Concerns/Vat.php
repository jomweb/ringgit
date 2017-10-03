<?php

namespace Duit\Concerns;

trait Vat
{
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
     * Enable GST/VAT for calculation.
     *
     * @return $this
     */
    public function enableVat()
    {
        $this->vat = true;

        return $this;
    }

    /**
     * Disable GST/VAT for calculation.
     *
     * @return $this
     */
    public function disableVat()
    {
        $this->vat = false;

        return $this;
    }

    /**
     * Get GST/VAT amount.
     *
     * @return int
     */
    public function getVatAmount()
    {
        if (! $this->vat) {
            return '0';
        }

        return $this->money->multiply(0.06)->getAmount();
    }

    /**
     * Returns the value represented by this object with GST/VAT.
     *
     * @return string
     */
    public function getAmountWithVat()
    {
        if (! $this->vat) {
            return $this->money->getAmount();
        }

        return $this->money->multiply(1.06)->getAmount();
    }

    /**
     * Allocate the money according to a list of ratios with GST/VAT.
     *
     * @param  array  $ratios
     *
     * @return Money[]
     */
    public function allocateWithVat(array $ratios)
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
    public function allocateWithVatTo($n)
    {
        $results = [];
        $allocates = static::asMoney($this->getAmountWithVat())->allocateTo($n);

        foreach ($allocates as $allocate) {
            $results[] = static::afterVat($allocate->getAmount());
        }

        return $results;
    }

    /**
     * Build money object.
     *
     * @param  int|string  $amount
     *
     * @return \Money\Money
     */
    abstract protected static function asMoney($amount);
}
