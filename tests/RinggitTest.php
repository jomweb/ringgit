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
}
