<?php

namespace Duit\Taxable\Gst;

use Duit\Taxable\Gst;

class Standard extends Gst
{
    /**
     * GST code.
     *
     * @var string
     */
    protected $gstCode = 'SR';

    /**
     * Tax rate percentage.
     *
     * @var int
     */
    protected $taxRate = 6;
}
