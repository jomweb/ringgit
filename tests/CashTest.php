<?php

use Duit\MYR;
use PHPUnit\Framework\TestCase;

class CashTest extends TestCase
{
    /** @test */
    public function it_can_display_proper_amount()
    {
        $money = MYR::withoutGst(1043);

        $this->assertSame('1043', $money->getAmount());
        $this->assertSame('10.43', $money->amount());
        $this->assertSame('1043', $money->getAmountWithGst());
        $this->assertSame('10.43', $money->amountWithGst());

        $this->assertSame('1045', $money->getCashAmount());
        $this->assertSame('10.45', $money->cashAmount());
        $this->assertSame('1045', $money->getCashAmountWithGst());
        $this->assertSame('10.45', $money->cashAmountWithGst());
    }

    /** @test */
    public function it_can_be_converted_to_supported_cash_value()
    {
        $this->assertSame('500', MYR::withoutGst('501')->getCashAmount());
        $this->assertSame('500', MYR::withoutGst('502')->getCashAmount());
        $this->assertSame('505', MYR::withoutGst('503')->getCashAmount());
        $this->assertSame('505', MYR::withoutGst('504')->getCashAmount());
        $this->assertSame('505', MYR::withoutGst('505')->getCashAmount());

        $this->assertSame('505', MYR::withoutGst('506')->getCashAmount());
        $this->assertSame('505', MYR::withoutGst('507')->getCashAmount());
        $this->assertSame('510', MYR::withoutGst('508')->getCashAmount());
        $this->assertSame('510', MYR::withoutGst('509')->getCashAmount());
        $this->assertSame('510', MYR::withoutGst('510')->getCashAmount());
    }

    /** @test */
    public function it_can_be_converted_to_supported_cash_value_with_vat()
    {
        $this->assertSame('530', MYR::beforeGst('501')->getCashAmountWithGst());
        $this->assertSame('530', MYR::beforeGst('502')->getCashAmountWithGst());
        $this->assertSame('535', MYR::beforeGst('503')->getCashAmountWithGst());
        $this->assertSame('535', MYR::beforeGst('504')->getCashAmountWithGst());
        $this->assertSame('535', MYR::beforeGst('505')->getCashAmountWithGst());

        $this->assertSame('535', MYR::beforeGst('506')->getCashAmountWithGst());
        $this->assertSame('535', MYR::beforeGst('507')->getCashAmountWithGst());
        $this->assertSame('540', MYR::beforeGst('508')->getCashAmountWithGst());
        $this->assertSame('540', MYR::beforeGst('509')->getCashAmountWithGst());
        $this->assertSame('540', MYR::beforeGst('510')->getCashAmountWithGst());
    }
}
