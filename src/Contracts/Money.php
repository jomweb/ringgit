<?php

namespace Duit\Contracts;

interface Money
{
    /**
     * Returns the value represented by this object.
     *
     * @return string
     */
    public function getAmount();

    /**
     * Get the money object.
     *
     * @return \Money\Money
     */
    public function getMoney();
}
