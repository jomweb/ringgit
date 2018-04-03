<?php

use Duit\MYR;
use PHPUnit\Framework\TestCase;

class GstTest extends TestCase
{
    /** @test */
    public function it_can_enable_gst_after_initiated()
    {
        $money = MYR::withoutGst(500);

        $this->assertSame('5.00', $money->amountWithGst());
        $this->assertSame('500', $money->getAmountWithGst());
        $this->assertSame('0', $money->getGstAmount());

        $money->enableGst();

        $this->assertSame('5.30', $money->amountWithGst());
        $this->assertSame('530', $money->getAmountWithGst());
        $this->assertSame('30', $money->getGstAmount());
    }

    /** @test */
    public function it_can_disable_gst_after_initiated()
    {
        $money = MYR::afterGst(530);

        $this->assertSame('5.30', $money->amountWithGst());
        $this->assertSame('530', $money->getAmountWithGst());
        $this->assertSame('30', $money->getGstAmount());

        $money->disableGst();

        $this->assertSame('5.00', $money->amountWithGst());
        $this->assertSame('500', $money->getAmountWithGst());
        $this->assertSame('0', $money->getGstAmount());
    }

    /** @test */
    public function it_can_be_declared_without_gst_as_default()
    {
        $money = MYR::withoutGst(500);

        $this->assertSame('0', $money->getGstAmount());

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('5.00', $money->amount());
        $this->assertSame('500', $money->getAmountWithGst());
        $this->assertSame('5.00', $money->amountWithGst());
        $this->assertSame('500', $money->getCashAmountWithGst());
        $this->assertSame('5.00', $money->cashAmountWithGst());
    }

    /** @test */
    public function it_can_display_proper_amount_with_gst()
    {
        $money = MYR::beforeGst(1045);

        $this->assertSame('63', $money->getGstAmount());

        $this->assertSame('1045', $money->getAmount());
        $this->assertSame('10.45', $money->amount());
        $this->assertSame('1108', $money->getAmountWithGst());
        $this->assertSame('11.08', $money->amountWithGst());
        $this->assertSame('1110', $money->getCashAmountWithGst());
        $this->assertSame('11.10', $money->cashAmountWithGst());
    }

    /** @test */
    public function it_can_be_declared_with_gst()
    {
        $money = MYR::beforeGst(501);

        $this->assertSame('30', $money->getGstAmount());

        $this->assertSame('501', $money->getAmount());
        $this->assertSame('5.01', $money->amount());
        $this->assertSame('531', $money->getAmountWithGst());
        $this->assertSame('5.31', $money->amountWithGst());
        $this->assertSame('530', $money->getCashAmountWithGst());
        $this->assertSame('5.30', $money->cashAmountWithGst());
    }

    /** @test */
    public function it_can_be_allocated_with_gst()
    {
        $money = MYR::beforeGst(500);

        $allocation = $money->allocateWithGst([1, 1, 1]);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('167', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('10', $allocation[0]->getGstAmount());
        $this->assertSame('10', $allocation[1]->getGstAmount());
        $this->assertSame('10', $allocation[2]->getGstAmount());

        $this->assertSame('177', $allocation[0]->getAmountWithGst());
        $this->assertSame('177', $allocation[1]->getAmountWithGst());
        $this->assertSame('176', $allocation[2]->getAmountWithGst());
    }

    /** @test */
    public function it_can_be_allocated_with_gst_using_n()
    {
        $money = MYR::beforeGst(500);

        $allocation = $money->allocateWithGstTo(3);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('167', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('10', $allocation[0]->getGstAmount());
        $this->assertSame('10', $allocation[1]->getGstAmount());
        $this->assertSame('10', $allocation[2]->getGstAmount());

        $this->assertSame('177', $allocation[0]->getAmountWithGst());
        $this->assertSame('177', $allocation[1]->getAmountWithGst());
        $this->assertSame('176', $allocation[2]->getAmountWithGst());
    }

    /** @test */
    public function it_doesnt_apply_redundant_gst()
    {
        $money = MYR::afterGst(530);

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('30', $money->getGstAmount());
        $this->assertSame('530', $money->getAmountWithGst());
    }
}
