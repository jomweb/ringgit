<?php

namespace Duit\Concerns;

use Money\Number;
use Money\MoneyFormatter;

trait Cash
{
    /**
     * Get formatted amount.
     *
     * @return numeric-string|non-empty-string
     */
    public function amount(): string
    {
        return $this->getFormatter()->format($this->getMoney());
    }

    /**
     * Get formatted cash.
     *
     * @return numeric-string|non-empty-string
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
     * @return numeric-string
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
     * @param  int|numeric-string  $amount
     */
    protected function getClosestAcceptedCashAmount($amount): int
    {
        /** @var int $value */
        $value = Number::fromString((string) $amount)->getIntegerPart();
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
     */
    abstract protected function getFormatter(): MoneyFormatter;
}
