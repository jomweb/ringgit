<?php

namespace Duit;

use Money\Money;
use Money\Currency;
use Money\MoneyFormatter;
use BadMethodCallException;
use InvalidArgumentException;
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
     * @var \Money\MoneyFormatter
     */
    protected static $formatter;

    /**
     * Construct a new MYR money.
     *
     * @param int|numeric-string $amount
     */
    public function __construct($amount)
    {
        $this->money = static::asMoney($amount);
    }

    /**
     * Construct a new MYR money.
     *
     * @param  int|numeric-string  $amount
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
     * @param  numeric-string|array  $value
     *
     * @return static
     */
    public static function parse($value)
    {
        $parser = new DecimalMoneyParser(new ISOCurrencies());
        $currency = 'MYR';

        if (\is_array($value) && isset($value['amount']) && isset($value['currency'])) {
            if ($value['currency'] !== 'MYR') {
                throw new InvalidArgumentException("Unable to handle parsing {$value['currency']} currency");
            }

            $value = $value['amount'];
        }

        return static::given(
            $parser->parse((string) $value, new Currency($currency))->getAmount()
        );
    }

    /**
     * Returns the value represented by this object.
     *
     * @return numeric-string
     */
    public function getAmount(): string
    {
        return $this->money->getAmount();
    }

    /**
     * Get the money currency.
     */
    public function getCurrency(): Currency
    {
        return $this->money->getCurrency();
    }

    /**
     * Get the money implementation.
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
     * Passthroughs method call to Money\Money.
     *
     * @throws \BadMethodCallException if method doesn't exist
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        if (! method_exists($this->money, $method)) {
            throw new BadMethodCallException("Method [{$method}] is not available.");
        }

        $comparison = [
            'add', 'subtract', 'equals', 'isSameCurrency',
            'lessThan', 'lessThanOrEqual', 'greaterThanOrEqual', 'greaterThan',
        ];

        if (\in_array($method, $comparison)) {
            $first = array_shift($parameters);

            /** @var \Money\Money|mixed $resolved */
            $resolved = $this->money->{$method}(
                $this->resolveMoneyObject($first), ...$parameters
            );

            return $resolved instanceof Money
                    ? $this->newInstance($resolved)
                    : $resolved;
        } elseif (\in_array($method, ['allocate', 'allocateTo'])) {
            return array_map(function ($money) {
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
     * @param  int|numeric-string  $amount
     */
    protected static function asMoney($amount): Money
    {
        return new Money($amount, new Currency('MYR'));
    }

    /**
     * Create new instance from money object.
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
     * @param  \Money\Money|\Duit\Contracts\Money  $money
     */
    protected function resolveMoneyObject($money): Money
    {
        return $money instanceof Contracts\Money ? $money->getMoney() : $money;
    }

    /**
     * Get money formatter.
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
     * @return void
     */
    public static function setFormatter(MoneyFormatter $formatter)
    {
        static::$formatter = $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->getAmount(),
            'cash' => $this->getCashAmount(),
            'tax' => $this->getTaxAmount(),
            'tax_code' => ! is_null($this->taxable) ? $this->taxable->taxCode() : null,
            'tax_rate' => ! is_null($this->taxable) ? $this->taxable->taxRate() : null,
            'amount_with_tax' => $this->getAmountWithTax(),
            'cash_with_tax' => $this->getCashAmountWithTax(),
            'currency' => $this->getCurrency()->jsonSerialize(),
        ];
    }
}
