<?php

namespace Duit;

use Money\Money;
use Money\Currency;
use BadMethodCallException;

class MYR implements Contracts\Money
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
     * Create new instance from money object.
     *
     * @param  int|string  $amount
     *
     * @return static
     */
    public function newInstance($amount)
    {
        return new static($amount);
    }

    /**
     * Get the money implementation.
     *
     * @return \Money\Money
     */
    public function getMoney()
    {
        return $this->money;
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

        $passthrough = [
            'add', 'subtract', 'equals', 'isSameCurrency',
            'lessThan', 'lessThanOrEqual', 'greaterThanOrEqual', 'greaterThan',
        ];

        if (in_array($method, $passthrough)) {
            $first = array_shift($parameters);

            return $this->newInstance(
                call_user_func(
                    [$this->money, $method],
                    $this->resolveMoneyObject($first),
                    ...$parameters
                )
            );
        }

        return call_user_func([$this->money, $method], ...$parameters);
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
     * Resolve money object.
     *
     * @param  \Money\Money|Duit\Contracts\Money  $money
     * @return \Money\Money
     */
    protected function resolveMoneyObject($money)
    {
        return $money instanceof Contracts\Money ? $money->getMoney() : $money;
    }
}
