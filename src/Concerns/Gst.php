<?php

namespace Duit\Concerns;

use Money\Money;
use Money\MoneyFormatter;

trait Gst
{
    use Cash;

    /**
     * Enable GST/VAL calculation.
     *
     * @var bool
     */
    protected $gst = false;

    /**
     * Make object with GST.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function afterGst($amount)
    {
        return static::beforeGst(
            static::asMoney($amount)->divide(1.06)->getAmount()
        );
    }

    /**
     * Make object without GST.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function withoutGst($amount)
    {
        return (new static($amount))->disableGst();
    }

    /**
     * Make object before applying GST.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function beforeGst($amount)
    {
        return (new static($amount))->enableGst();
    }

    /**
     * Get formatted amount with GST.
     *
     * @return string
     */
    public function amountWithGst(): string
    {
        return $this->getFormatter()->format(
            static::asMoney($this->getAmountWithGst())
        );
    }

    /**
     * Get formatted cash with GST.
     *
     * @return string
     */
    public function cashAmountWithGst(): string
    {
        return $this->getFormatter()->format(
            static::asMoney($this->getCashAmountWithGst())
        );
    }

    /**
     * Enable GST for calculation.
     *
     * @return $this
     */
    final public function enableGst(): self
    {
        $this->gst = true;

        return $this;
    }

    /**
     * Disable GST for calculation.
     *
     * @return $this
     */
    final public function disableGst(): self
    {
        $this->gst = false;

        return $this;
    }

    /**
     * Get GST amount.
     *
     * @return string
     */
    public function getGstAmount(): string
    {
        if (! $this->gst) {
            return '0';
        }

        return $this->getMoney()->multiply(0.06)->getAmount();
    }

    /**
     * Returns the value represented by this object with GST.
     *
     * @return string
     */
    public function getAmountWithGst(): string
    {
        if (! $this->gst) {
            return $this->getMoney()->getAmount();
        }

        return $this->getMoney()->multiply(1.06)->getAmount();
    }

    /**
     * Get amount for cash with GST.
     *
     * @return string
     */
    public function getCashAmountWithGst(): string
    {
        return (string) $this->getClosestAcceptedCashAmount(
            $this->getAmountWithGst()
        );
    }

    /**
     * Allocate the money according to a list of ratios with GST.
     *
     * @param  array  $ratios
     *
     * @return Money[]
     */
    public function allocateWithGst(array $ratios): array
    {
        $results = [];
        $allocates = static::asMoney($this->getAmountWithGst())->allocate($ratios);

        foreach ($allocates as $allocate) {
            $results[] = static::afterGst($allocate->getAmount());
        }

        return $results;
    }

    /**
     * Allocate the money among N targets with GST.
     *
     * @param  int  $n
     *
     * @throws \InvalidArgumentException If number of targets is not an integer
     *
     * @return Money[]
     */
    public function allocateWithGstTo(int $n): array
    {
        $results = [];
        $allocates = static::asMoney($this->getAmountWithGst())->allocateTo($n);

        foreach ($allocates as $allocate) {
            $results[] = static::afterGst($allocate->getAmount());
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
