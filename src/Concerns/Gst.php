<?php

namespace Duit\Concerns;

use Duit\Taxable\Gst\ZeroRate;
use Duit\Taxable\Gst\StandardRate;

trait Gst
{
    use Tax;

    /**
     * Make object with GST.
     *
     * @param int|numeric-string $amount
     *
     * @return static
     */
    public static function afterGst($amount)
    {
        return static::afterTax($amount, new StandardRate());
    }

    /**
     * Make object before applying GST.
     *
     * @param int|numeric-string $amount
     *
     * @return static
     */
    public static function beforeGst($amount)
    {
        return (new static($amount))->useGstStandardRate();
    }

    /**
     * Make object without GST.
     *
     * @param int|numeric-string $amount
     *
     * @return static
     */
    public static function withoutGst($amount)
    {
        return (new static($amount))->useGstZeroRate();
    }

    /**
     * Enable GST for calculation.
     *
     * @return $this
     */
    final public function useGstStandardRate(): self
    {
        return $this->enableTax(new StandardRate());
    }

    /**
     * Disable GST for calculation.
     *
     * @return $this
     */
    final public function useGstZeroRate(): self
    {
        return $this->enableTax(new ZeroRate());
    }
}
