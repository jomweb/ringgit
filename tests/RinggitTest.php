<?php

use Money\MYR;
use PHPUnit\Framework\TestCase;

class RinggitTest extends TestCase
{
    /** @test */
    public function it_can_be_declared_without_vat_as_default()
    {
        $money = new MYR(500);

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('0', $money->getVatAmount());
    }

    /** @test */
    public function it_can_be_declared_with_vat()
    {
        $money = new MYR(500);
        $money->withVat();

        $this->assertSame('500', $money->getAmount());
        $this->assertSame('30', $money->getVatAmount());
        $this->assertSame('530', $money->getAmountWithVat());
    }

    /** @test */
    public function it_can_be_allocated_with_vat()
    {
        $money = new MYR(500);
        $money->withVat();

        $allocation = $money->allocateWithVat([1, 1, 1]);

        $this->assertSame('177', $allocation[0]->getAmount());
        $this->assertSame('177', $allocation[1]->getAmount());
        $this->assertSame('176', $allocation[2]->getAmount());
    }

    /** @test */
    public function it_can_be_allocated_with_vat_using_n()
    {
        $money = new MYR(500);
        $money->withVat();

        $allocation = $money->allocateWithVatTo(3);

        $this->assertSame('177', $allocation[0]->getAmount());
        $this->assertSame('177', $allocation[1]->getAmount());
        $this->assertSame('176', $allocation[2]->getAmount());
    }
}
