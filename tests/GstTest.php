<?php

namespace Duit\Tests;

use Duit\MYR;
use Duit\Taxable\Gst\ZeroRate;
use PHPUnit\Framework\TestCase;
use Duit\Taxable\Gst\StandardRate;

class GstTest extends TestCase
{
    /** @test */
    public function it_can_enable_gst_after_initiated()
    {
        $money = MYR::withoutGst(500);

        $this->assertSame('5.00', $money->amountWithTax());
        $this->assertSame('500', $money->getAmountWithTax());
        $this->assertSame('0', $money->getTaxAmount());
        $this->assertTrue($money->hasTax());
        $this->assertInstanceOf(ZeroRate::class, $money->getTax());

        $money->useGstStandardRate();

        $this->assertSame('5.30', $money->amountWithTax());
        $this->assertSame('530', $money->getAmountWithTax());
        $this->assertSame('30', $money->getTaxAmount());
        $this->assertTrue($money->hasTax());
        $this->assertInstanceOf(StandardRate::class, $money->getTax());
    }

    /** @test */
    public function it_can_disable_gst_after_initiated()
    {
        $money = MYR::afterGst(530);

        $this->assertSame('5.30', $money->amountWithTax());
        $this->assertSame('530', $money->getAmountWithTax());
        $this->assertSame('30', $money->getTaxAmount());

        $money->useGstZeroRate();

        $this->assertSame('5.00', $money->amountWithTax());
        $this->assertSame('500', $money->getAmountWithTax());
        $this->assertSame('0', $money->getTaxAmount());
    }

    /** @test */
    public function it_can_be_declared_without_gst_as_default()
    {
        $money = MYR::withoutGst(500);

        $this->assertSame('0', $money->getTaxAmount());

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('5.00', $money->amount());
        $this->assertSame('500', $money->getAmountWithTax());
        $this->assertSame('5.00', $money->amountWithTax());
        $this->assertSame('500', $money->getCashAmountWithTax());
        $this->assertSame('5.00', $money->cashAmountWithTax());
    }

    /** @test */
    public function it_can_display_proper_amount_with_gst()
    {
        $money = MYR::beforeGst(1045);

        $this->assertSame('63', $money->getTaxAmount());

        $this->assertSame('1045', $money->getAmount());
        $this->assertSame('10.45', $money->amount());
        $this->assertSame('1108', $money->getAmountWithTax());
        $this->assertSame('11.08', $money->amountWithTax());
        $this->assertSame('1110', $money->getCashAmountWithTax());
        $this->assertSame('11.10', $money->cashAmountWithTax());
    }

    /** @test */
    public function it_can_be_declared_with_gst()
    {
        $money = MYR::beforeGst(501);

        $this->assertSame('30', $money->getTaxAmount());

        $this->assertSame('501', $money->getAmount());
        $this->assertSame('5.01', $money->amount());
        $this->assertSame('531', $money->getAmountWithTax());
        $this->assertSame('5.31', $money->amountWithTax());
        $this->assertSame('530', $money->getCashAmountWithTax());
        $this->assertSame('5.30', $money->cashAmountWithTax());
    }

    /** @test */
    public function it_can_be_allocated_with_gst()
    {
        $money = MYR::beforeGst(500);

        $allocation = $money->allocateWithTax([1, 1, 1]);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('167', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('10', $allocation[0]->getTaxAmount());
        $this->assertSame('10', $allocation[1]->getTaxAmount());
        $this->assertSame('10', $allocation[2]->getTaxAmount());

        $this->assertSame('177', $allocation[0]->getAmountWithTax());
        $this->assertSame('177', $allocation[1]->getAmountWithTax());
        $this->assertSame('176', $allocation[2]->getAmountWithTax());

        $this->assertTrue($allocation[0]->hasTax());
        $this->assertTrue($allocation[1]->hasTax());
        $this->assertTrue($allocation[2]->hasTax());
    }

    /** @test */
    public function it_can_be_allocated_with_gst_using_n()
    {
        $money = MYR::beforeGst(500);

        $allocation = $money->allocateWithTaxTo(3);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('167', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('10', $allocation[0]->getTaxAmount());
        $this->assertSame('10', $allocation[1]->getTaxAmount());
        $this->assertSame('10', $allocation[2]->getTaxAmount());

        $this->assertSame('177', $allocation[0]->getAmountWithTax());
        $this->assertSame('177', $allocation[1]->getAmountWithTax());
        $this->assertSame('176', $allocation[2]->getAmountWithTax());

        $this->assertTrue($allocation[0]->hasTax());
        $this->assertTrue($allocation[1]->hasTax());
        $this->assertTrue($allocation[2]->hasTax());
    }

    /** @test */
    public function it_doesnt_apply_redundant_gst()
    {
        $money = MYR::afterGst(530);

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('30', $money->getTaxAmount());
        $this->assertSame('530', $money->getAmountWithTax());
    }

    /** @test */
    public function it_can_be_converted_to_json()
    {
        $money = MYR::afterGst(1124);

        $this->assertSame('{"amount":"1060","cash":"1060","tax":"64","tax_code":"GST:SR","tax_rate":0.06,"amount_with_tax":"1124","cash_with_tax":"1125","currency":"MYR"}', json_encode($money));
    }
}
