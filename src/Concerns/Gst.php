<?php

namespace Duit\Concerns;

trait Gst
{
    use Vat;

    /**
     * Make object with GST/VAT.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function afterGst($amount)
    {
        return static::afterVat($amount);
    }

    /**
     * Make object without GST/VAT.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function withoutGst($amount)
    {
        return static::withoutVat($amount);
    }

    /**
     * Make object before applying GST/VAT.
     *
     * @param int|string $amount
     *
     * @return static
     */
    public static function beforeGst($amount)
    {
        return static::beforeVat($amount);
    }

    /**
     * Get formatted amount with GST/VAT.
     *
     * @return string
     */
    public function amountWithGst()
    {
        return $this->amountWithVat();
    }

    /**
     * Get formatted cash with GST/VAT.
     *
     * @return string
     */
    public function cashAmountWithGst()
    {
        return $this->cashAmountWithVat();
    }

    /**
     * Enable GST/VAT for calculation.
     *
     * @return $this
     */
    public function enableGst()
    {
        return $this->enableVat();
    }

    /**
     * Disable GST/VAT for calculation.
     *
     * @return $this
     */
    public function disableGst()
    {
        return $this->disableVat();
    }

    /**
     * Get GST/VAT amount.
     *
     * @return int
     */
    public function getGstAmount()
    {
        return $this->getVatAmount();
    }

    /**
     * Returns the value represented by this object with GST/VAT.
     *
     * @return string
     */
    public function getAmountWithGst()
    {
        return $this->getAmountWithVat();
    }

    /**
     * Get amount for cash with GST/VAT.
     *
     * @return string
     */
    public function getCashAmountWithGst()
    {
        return $this->getCashAmountWithVat();
    }

    /**
     * Allocate the money according to a list of ratios with GST/VAT.
     *
     * @param  array  $ratios
     *
     * @return Money[]
     */
    public function allocateWithGst(array $ratios)
    {
        return $this->allocateWithVat($ratios);
    }

    /**
     * Allocate the money among N targets with GST/VAT.
     *
     * @param  int  $n
     *
     * @throws \InvalidArgumentException If number of targets is not an integer
     *
     * @return Money[]
     */
    public function allocateWithGstTo($n)
    {
        return $this->allocateWithVatTo($n);
    }
}
