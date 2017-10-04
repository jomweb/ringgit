<?php

use Duit\MYR;
use PHPUnit\Framework\TestCase;

class CashTest extends TestCase
{
    /** @test */
    public function it_can_display_proper_amount()
    {
        $money = MYR::withoutVat(1043);

        $this->assertSame('1043', $money->getAmount());
        $this->assertSame('10.43', $money->amount());
        $this->assertSame('1043', $money->getAmountWithVat());
        $this->assertSame('10.43', $money->amountWithVat());

        $this->assertSame('1045', $money->getCashAmount());
        $this->assertSame('10.45', $money->cashAmount());
        $this->assertSame('1045', $money->getCashAmountWithVat());
        $this->assertSame('10.45', $money->cashAmountWithVat());
    }

    /** @test */
    public function it_can_be_converted_to_supported_cash_value()
    {
        $this->assertSame('500', MYR::withoutVat('501')->getCashAmount());
        $this->assertSame('500', MYR::withoutVat('502')->getCashAmount());
        $this->assertSame('505', MYR::withoutVat('503')->getCashAmount());
        $this->assertSame('505', MYR::withoutVat('504')->getCashAmount());
        $this->assertSame('505', MYR::withoutVat('505')->getCashAmount());

        $this->assertSame('505', MYR::withoutVat('506')->getCashAmount());
        $this->assertSame('505', MYR::withoutVat('507')->getCashAmount());
        $this->assertSame('510', MYR::withoutVat('508')->getCashAmount());
        $this->assertSame('510', MYR::withoutVat('509')->getCashAmount());
        $this->assertSame('510', MYR::withoutVat('510')->getCashAmount());
    }

    /** @test */
    public function it_can_be_converted_to_supported_cash_value_with_vat()
    {
        $this->assertSame('530', MYR::beforeVat('501')->getCashAmountWithVat());
        $this->assertSame('530', MYR::beforeVat('502')->getCashAmountWithVat());
        $this->assertSame('535', MYR::beforeVat('503')->getCashAmountWithVat());
        $this->assertSame('535', MYR::beforeVat('504')->getCashAmountWithVat());
        $this->assertSame('535', MYR::beforeVat('505')->getCashAmountWithVat());

        $this->assertSame('535', MYR::beforeVat('506')->getCashAmountWithVat());
        $this->assertSame('535', MYR::beforeVat('507')->getCashAmountWithVat());
        $this->assertSame('540', MYR::beforeVat('508')->getCashAmountWithVat());
        $this->assertSame('540', MYR::beforeVat('509')->getCashAmountWithVat());
        $this->assertSame('540', MYR::beforeVat('510')->getCashAmountWithVat());
    }
}
