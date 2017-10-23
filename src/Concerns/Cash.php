<?php

namespace Duit\Concerns;

use Money\Number;
use Money\MoneyFormatter;

trait Cash
{
    /**
     * Get formatted amount.
     *
     * @return string
     */
    public function amount(): string
    {
        return $this->getFormatter()->format($this->getMoney());
    }

    /**
     * Get formatted cash.
     *
     * @return string
     */
    public function cashAmount(): string
    {
        return $this->getFormatter()->format(
            static::asMoney($this->getCashAmount())
        );
    }

    /**
     * Get amount for cash.
     *
     * @return string
     */
    public function getCashAmount(): string
    {
        return (string) $this->getClosestAcceptedCashAmount(
            $this->getMoney()->getAmount()
        );
    }

    /**
     * Get closest accepted cash amount.
     *
     * @param  int|string  $amount
     *
     * @return int
     */
    protected function getClosestAcceptedCashAmount($amount): int
    {
        $value = Number::fromString($amount)->getIntegerPart();
        $cent = $amount % 5;

        if ($cent <= 2) {
            $value = $value - $cent;
        } else {
            $value = $value + (5 - $cent);
        }

        return $value;
    }

    /**
     * Get money formatter.
     *
     * @return \Money\MoneyFormatter
     */
    abstract protected function getFormatter(): MoneyFormatter;
}
