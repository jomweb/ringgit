<?php

namespace Duit\Taxable;

use Duit\Taxable;

class Sst extends Taxable
{
    /**
     * Tax code.
     *
     * @var string
     */
    protected $taxCode = 'SST';

    /**
     * Tax rate percentage.
     *
     * @var int
     */
    protected $taxRate = 10;
}
