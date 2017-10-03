<?php

namespace Duit;

use Money\Money;
use Money\Currency;
use BadMethodCallException;

class MYR
{
    use Concerns\Vat;

    /**
     * Money implementation.
     *
     * @var \Money\Money
     */
    protected $money;

    /**
     * Construct a new MYR money.
     *
     * @param int|string $amount
     */
    public function __construct($amount)
    {
        $this->money = static::asMoney($amount);
    }

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
     * Build money object.
     *
     * @param  int|string  $amount
     *
     * @return \Money\Money
     */
    protected static function asMoney($amount)
    {
        return new Money($amount, new Currency('MYR'));
    }

    /**
     * Passthrough method call to Money\Money.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @throws \BadMethodException if method doesn't exist
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        if (! method_exists($this->money, $method)) {
            throw new BadMethodCallException("Method [{$method}] is not available.");
        }

        return call_user_func_array([$this->money, $method], $parameters);
    }
}
