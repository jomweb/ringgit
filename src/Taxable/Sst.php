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

    /**
     * Construct a new SST tax.
     */
    public function __construct(int $taxRate = 10)
    {
        $this->validateTaxRate($taxRate);

        $this->taxRate = $taxRate;
    }
}
