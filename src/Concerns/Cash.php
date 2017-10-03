<?php

namespace Duit\Concerns;

use Money\Number;

trait Cash
{
    /**
     * Get absolute value.
     *
     * @return string
     */
    public function amount()
    {
        return $this->getFormatter()->format($this->getMoney());
    }

    /**
     * Get amount for cash.
     *
     * @return string
     */
    public function getCashAmount()
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
    protected function getClosestAcceptedCashAmount($amount)
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
     * @return \Money\Formatter\IntlMoneyFormatter
     */
    abstract protected function getFormatter();
}
