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
    public function amountWithGst(): string
    {
        return $this->amountWithVat();
    }

    /**
     * Get formatted cash with GST/VAT.
     *
     * @return string
     */
    public function cashAmountWithGst(): string
    {
        return $this->cashAmountWithVat();
    }

    /**
     * Enable GST/VAT for calculation.
     *
     * @return $this
     */
    final public function enableGst(): self
    {
        return $this->enableVat();
    }

    /**
     * Disable GST/VAT for calculation.
     *
     * @return $this
     */
    final public function disableGst(): self
    {
        return $this->disableVat();
    }

    /**
     * Get GST/VAT amount.
     *
     * @return string
     */
    public function getGstAmount(): string
    {
        return $this->getVatAmount();
    }

    /**
     * Returns the value represented by this object with GST/VAT.
     *
     * @return string
     */
    public function getAmountWithGst(): string
    {
        return $this->getAmountWithVat();
    }

    /**
     * Get amount for cash with GST/VAT.
     *
     * @return string
     */
    public function getCashAmountWithGst(): string
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
    public function allocateWithGst(array $ratios): array
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
    public function allocateWithGstTo(int $n): array
    {
        return $this->allocateWithVatTo($n);
    }
}
