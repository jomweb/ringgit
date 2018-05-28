<?php

namespace Duit\Concerns;

use Duit\Taxable\Gst\Standard;

trait Gst
{
    use Tax;

    /**
     * Make object with GST.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function afterGst($amount)
    {
        return static::afterTax($amount, new Standard());
    }

    /**
     * Make object before applying GST.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function beforeGst($amount)
    {
        return (new static($amount))->enableTax(new Standard());
    }

    /**
     * Make object without GST.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function withoutGst($amount)
    {
        return (new static($amount))->disableTax();
    }

    /**
     * Enable GST for calculation.
     *
     * @return $this
     */
    final public function enableGst(): self
    {
        return $this->enableTax(new Standard());
    }

    /**
     * Disable GST for calculation.
     *
     * @return $this
     */
    final public function disableGst(): self
    {
        return $this->disableTax();
    }
}
