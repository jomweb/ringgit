<?php

namespace Duit;

use Money\Money;
use Money\Currency;
use BadMethodCallException;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

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
     * Money formatter.
     *
     * @var \Money\Formatter\IntlMoneyFormatter
     */
    protected static $formatter;

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
     * Returns the value represented by this object.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->money->getAmount();
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
     * Create new instance from money object.
     *
     * @param  \Money\Money  $money
     *
     * @return static
     */
    protected function newInstance(Money $money)
    {
        return new static($money->getAmount());
    }

    /**
     * Resolve money object.
     *
     * @param  \Money\Money|Duit\Contracts\Money  $money
     *
     * @return \Money\Money
     */
    protected function resolveMoneyObject($money)
    {
        return $money instanceof Contracts\Money ? $money->getMoney() : $money;
    }

    /**
     * Get money formatter.
     *
     * @return \Money\Formatter\IntlMoneyFormatter
     */
    protected function getFormatter()
    {
        if (is_null(static::$formatter)) {
            static::$formatter = new DecimalMoneyFormatter(
                new ISOCurrencies()
            );
        }

        return static::$formatter;
    }
}
