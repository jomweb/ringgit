<?php

namespace Duit;

use Money\Money;
use Money\Currency;
use Money\MoneyFormatter;
use BadMethodCallException;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Money\Formatter\DecimalMoneyFormatter;

class MYR implements Contracts\Money, \JsonSerializable
{
    use Concerns\Gst;

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
     * Construct a new MYR money.
     *
     * @param  int|string  $amount
     *
     * @return static
     */
    public static function given($amount)
    {
        return static::withoutTax($amount);
    }

    /**
     * Parse value as ringgit.
     *
     * @param  string  $amount
     *
     * @return static
     */
    public static function parse(string $amount)
    {
        $parser = new DecimalMoneyParser(new ISOCurrencies());

        return static::given(
            $parser->parse($amount, new Currency('MYR'))->getAmount()
        );
    }

    /**
     * Returns the value represented by this object.
     *
     * @return string
     */
    public function getAmount(): string
    {
        return $this->money->getAmount();
    }

    /**
     * Get the money currency.
     *
     * @return \Money\Currency
     */
    public function getCurrency(): Currency
    {
        return $this->money->getCurrency();
    }

    /**
     * Get the money implementation.
     *
     * @return \Money\Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }

    /**
     * Get applied tax.
     *
     * @return \Duit\Contracts\Taxable|null
     */
    final public function getTax(): ?Contracts\Taxable
    {
        return $this->taxable;
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
    public function __call(string $method, array $parameters)
    {
        if (! \method_exists($this->money, $method)) {
            throw new BadMethodCallException("Method [{$method}] is not available.");
        }

        $comparison = [
            'add', 'subtract', 'equals', 'isSameCurrency',
            'lessThan', 'lessThanOrEqual', 'greaterThanOrEqual', 'greaterThan',
        ];

        if (\in_array($method, $comparison)) {
            $first = \array_shift($parameters);

            $resolved = $this->money->{$method}(
                $this->resolveMoneyObject($first), ...$parameters
            );

            return $resolved instanceof Money
                    ? $this->newInstance($resolved)
                    : $resolved;
        } elseif (\in_array($method, ['allocate', 'allocateTo'])) {
            return \array_map(function ($money) {
                return $this->newInstance($money);
            }, $this->money->{$method}(...$parameters));
        } elseif (\in_array($method, ['isZero', 'isPositive', 'isNegative'])) {
            return $this->money->{$method}(...$parameters);
        }

        return $this->newInstance(
            $this->money->{$method}(...$parameters)
        );
    }

    /**
     * Build money object.
     *
     * @param  int|string  $amount
     *
     * @return \Money\Money
     */
    protected static function asMoney($amount): Money
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
    protected function resolveMoneyObject($money): Money
    {
        return $money instanceof Contracts\Money ? $money->getMoney() : $money;
    }

    /**
     * Get money formatter.
     *
     * @return \Money\MoneyFormatter
     */
    protected function getFormatter(): MoneyFormatter
    {
        if (! static::$formatter instanceof MoneyFormatter) {
            static::setFormatter(
                new DecimalMoneyFormatter(new ISOCurrencies())
            );
        }

        return static::$formatter;
    }

    /**
     * Set money formatter.
     *
     * @param  \Money\MoneyFormatter  $formatter
     *
     * @return void
     */
    public static function setFormatter(MoneyFormatter $formatter)
    {
        static::$formatter = $formatter;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->getAmount(),
            'cash' => $this->getCashAmount(),
            'tax' => $this->getTaxAmount(),
            'tax_code' => $this->hasTax() ? $this->taxable->taxCode() : null,
            'tax_rate' => $this->hasTax() ? $this->taxable->taxRate() : null,
            'amount_with_tax' => $this->getAmountWithTax(),
            'cash_with_tax' => $this->getCashAmountWithTax(),
            'currency' => $this->getCurrency()->jsonSerialize(),
        ];
    }
}
