<?php

namespace Duit\Taxable\Gst;

use Duit\Taxable\Gst;

class ZeroRate extends Gst
{
    /**
     * GST code.
     *
     * @var string
     */
    protected $gstCode = 'ZR';

    /**
     * Tax rate percentage.
     *
     * @var int
     */
    protected $taxRate = 0;
}
