<?php

namespace Money;

use BadMethodCallException;

class MYR
{
    /**
     * Money implementation.
     *
     * @var \Money\Money
     */
    protected $money;

    /**
     * Enable GST/VAL calculation.
     *
     * @var bool
     */
    protected $vat = false;

    /**
     * Construct a new MYR money.
     *
     * @param int|string $amount
     */
    public function __construct($amount)
    {
        $this->money = new Money($amount, new Currency('MYR'));
    }

    /**
     * Enable GST/VAT for calculation.
     *
     * @return $this
     */
    public function withVat()
    {
        $this->vat = true;

        return $this;
    }

    /**
     * Disable GST/VAT for calculation.
     *
     * @return $this
     */
    public function withoutVat()
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
     * @return Money[]
     */
    public function allocateWithVat(array $ratios)
    {
        return (new Money($this->getAmountWithVat(), new Currency('MYR')))
                    ->allocate($ratios);
    }
    /**
     * Allocate the money among N targets with GST/VAT.
     *
     * @param  int  $n
     * @return Money[]
     *
     * @throws \InvalidArgumentException If number of targets is not an integer
     */
    public function allocateWithVatTo($n)
    {
        return (new Money($this->getAmountWithVat(), new Currency('MYR')))
                    ->allocateTo($n);
    }

    public function __call($method, array $parameters)
    {
        if (! method_exists($this->money, $method)) {
            throw new BadMethodCallException("Method [{$method}] is not available.");
        }

        return call_user_func_array([$this->money, $method], $parameters);
    }
}
