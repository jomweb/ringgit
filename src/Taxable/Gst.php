<?php

namespace Duit\Taxable;

use Duit\Taxable;

abstract class Gst extends Taxable
{
    /**
     * Tax code.
     *
     * @var string
     */
    protected $taxCode = 'GST';

    /**
     * GST code.
     *
     * @var string
     */
    protected $gstCode;

    /**
     * Tax code.
     */
    public function taxCode(): string
    {
        return "{$this->taxCode}:{$this->gstCode}";
    }
}
