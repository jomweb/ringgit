<?php

use Duit\MYR;
use PHPUnit\Framework\TestCase;

class VatTest extends TestCase
{
    /** @test */
    public function it_can_be_declared_without_vat_as_default()
    {
        $money = MYR::withoutVat(500);

        $this->assertSame('0', $money->getVatAmount());

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('5.00', $money->amount());
        $this->assertSame('500', $money->getAmountWithVat());
        $this->assertSame('5.00', $money->amountWithVat());
        $this->assertSame('500', $money->getCashAmountWithVat());
        $this->assertSame('5.00', $money->cashAmountWithVat());
    }

    /** @test */
    public function it_can_display_proper_amount_with_vat()
    {
        $money = MYR::beforeVat(1045);

        $this->assertSame('63', $money->getVatAmount());

        $this->assertSame('1045', $money->getAmount());
        $this->assertSame('10.45', $money->amount());
        $this->assertSame('1108', $money->getAmountWithVat());
        $this->assertSame('11.08', $money->amountWithVat());
        $this->assertSame('1110', $money->getCashAmountWithVat());
        $this->assertSame('11.10', $money->cashAmountWithVat());
    }

    /** @test */
    public function it_can_be_declared_with_vat()
    {
        $money = MYR::beforeVat(501);

        $this->assertSame('30', $money->getVatAmount());

        $this->assertSame('501', $money->getAmount());
        $this->assertSame('5.01', $money->amount());
        $this->assertSame('531', $money->getAmountWithVat());
        $this->assertSame('5.31', $money->amountWithVat());
        $this->assertSame('530', $money->getCashAmountWithVat());
        $this->assertSame('5.30', $money->cashAmountWithVat());
    }

    /** @test */
    public function it_can_be_allocated_with_vat()
    {
        $money = MYR::beforeVat(500);

        $allocation = $money->allocateWithVat([1, 1, 1]);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('167', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('10', $allocation[0]->getVatAmount());
        $this->assertSame('10', $allocation[1]->getVatAmount());
        $this->assertSame('10', $allocation[2]->getVatAmount());

        $this->assertSame('177', $allocation[0]->getAmountWithVat());
        $this->assertSame('177', $allocation[1]->getAmountWithVat());
        $this->assertSame('176', $allocation[2]->getAmountWithVat());
    }

    /** @test */
    public function it_can_be_allocated_with_vat_using_n()
    {
        $money = MYR::beforeVat(500);

        $allocation = $money->allocateWithVatTo(3);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('167', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('10', $allocation[0]->getVatAmount());
        $this->assertSame('10', $allocation[1]->getVatAmount());
        $this->assertSame('10', $allocation[2]->getVatAmount());

        $this->assertSame('177', $allocation[0]->getAmountWithVat());
        $this->assertSame('177', $allocation[1]->getAmountWithVat());
        $this->assertSame('176', $allocation[2]->getAmountWithVat());
    }

    /** @test */
    public function it_doesnt_apply_redundant_vat()
    {
        $money = MYR::afterVat(530);

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('30', $money->getVatAmount());
        $this->assertSame('530', $money->getAmountWithVat());
    }
}
