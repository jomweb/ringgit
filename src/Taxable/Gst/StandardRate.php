<?php

namespace Duit\Taxable\Gst;

use Duit\Taxable\Gst;

class StandardRate extends Gst
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
