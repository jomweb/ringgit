<?php

namespace Duit\Tests\Taxable;

use Duit\MYR;
use Duit\Taxable;
use Duit\Taxable\Sst;
use PHPUnit\Framework\TestCase;

class SstTest extends TestCase
{
    /** @test */
    public function it_define_proper_signature()
    {
        $stub = new Sst();

        $this->assertInstanceOf(Taxable::class, $stub);
        $this->assertSame('SST', $stub->taxCode());
        $this->assertSame(0.10, $stub->taxRate());
    }

    /** @test */
    public function it_can_enable_sst_after_initiated()
    {
        $money = MYR::given(500);

        $this->assertSame('5.00', $money->amountWithTax());
        $this->assertSame('500', $money->getAmountWithTax());
        $this->assertSame('0', $money->getTaxAmount());
        $this->assertFalse($money->hasTax());
        $this->assertNull($money->getTax());

        $money->enableTax(new Sst());

        $this->assertSame('5.50', $money->amountWithTax());
        $this->assertSame('550', $money->getAmountWithTax());
        $this->assertSame('50', $money->getTaxAmount());
        $this->assertTrue($money->hasTax());
        $this->assertInstanceOf(Sst::class, $money->getTax());
    }

    /** @test */
    public function it_can_disable_sst_after_initiated()
    {
        $money = MYR::afterTax(550, new Sst());

        $this->assertSame('5.50', $money->amountWithTax());
        $this->assertSame('550', $money->getAmountWithTax());
        $this->assertSame('50', $money->getTaxAmount());

        $money->disableTax();

        $this->assertSame('5.00', $money->amountWithTax());
        $this->assertSame('500', $money->getAmountWithTax());
        $this->assertSame('0', $money->getTaxAmount());
    }

    /** @test */
    public function it_can_be_declared_without_sst_as_default()
    {
        $money = MYR::withoutTax(500, new Sst());

        $this->assertSame('0', $money->getTaxAmount());

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('5.00', $money->amount());
        $this->assertSame('500', $money->getAmountWithTax());
        $this->assertSame('5.00', $money->amountWithTax());
        $this->assertSame('500', $money->getCashAmountWithTax());
        $this->assertSame('5.00', $money->cashAmountWithTax());
    }

    /** @test */
    public function it_can_display_proper_amount_with_sst()
    {
        $money = MYR::beforeTax(1045, new Sst());

        $this->assertSame('105', $money->getTaxAmount());

        $this->assertSame('1045', $money->getAmount());
        $this->assertSame('10.45', $money->amount());
        $this->assertSame('1150', $money->getAmountWithTax());
        $this->assertSame('11.50', $money->amountWithTax());
        $this->assertSame('1150', $money->getCashAmountWithTax());
        $this->assertSame('11.50', $money->cashAmountWithTax());
    }

    /** @test */
    public function it_can_be_declared_with_sst()
    {
        $money = MYR::beforeTax(501, new Sst());

        $this->assertSame('50', $money->getTaxAmount());

        $this->assertSame('501', $money->getAmount());
        $this->assertSame('5.01', $money->amount());
        $this->assertSame('551', $money->getAmountWithTax());
        $this->assertSame('5.51', $money->amountWithTax());
        $this->assertSame('550', $money->getCashAmountWithTax());
        $this->assertSame('5.50', $money->cashAmountWithTax());
    }

    /** @test */
    public function it_can_be_allocated_with_sst()
    {
        $money = MYR::beforeTax(500, new Sst());

        $allocation = $money->allocateWithTax([1, 1, 1]);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('166', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('17', $allocation[0]->getTaxAmount());
        $this->assertSame('17', $allocation[1]->getTaxAmount());
        $this->assertSame('17', $allocation[2]->getTaxAmount());

        $this->assertSame('184', $allocation[0]->getAmountWithTax());
        $this->assertSame('183', $allocation[1]->getAmountWithTax());
        $this->assertSame('183', $allocation[2]->getAmountWithTax());

        $this->assertTrue($allocation[0]->hasTax());
        $this->assertTrue($allocation[1]->hasTax());
        $this->assertTrue($allocation[2]->hasTax());
    }

    /** @test */
    public function it_can_be_allocated_with_sst_using_n()
    {
        $money = MYR::beforeTax(500, new Sst());

        $allocation = $money->allocateWithTaxTo(3);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('166', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('17', $allocation[0]->getTaxAmount());
        $this->assertSame('17', $allocation[1]->getTaxAmount());
        $this->assertSame('17', $allocation[2]->getTaxAmount());

        $this->assertSame('184', $allocation[0]->getAmountWithTax());
        $this->assertSame('183', $allocation[1]->getAmountWithTax());
        $this->assertSame('183', $allocation[2]->getAmountWithTax());

        $this->assertTrue($allocation[0]->hasTax());
        $this->assertTrue($allocation[1]->hasTax());
        $this->assertTrue($allocation[2]->hasTax());
    }

    /** @test */
    public function it_doesnt_apply_redundant_sst()
    {
        $money = MYR::afterTax(530, new Sst());

        $this->assertSame('482', $money->getAmount());
        $this->assertSame('48', $money->getTaxAmount());
        $this->assertSame('530', $money->getAmountWithTax());
    }

    /** @test */
    public function it_can_be_converted_to_json()
    {
        $money = MYR::afterTax(1124, new Sst());

        $this->assertSame('{"amount":"1022","cash":"1020","tax":"102","tax_code":"SST","tax_rate":0.1,"amount_with_tax":"1124","cash_with_tax":"1125","currency":"MYR"}', json_encode($money));
    }
}
