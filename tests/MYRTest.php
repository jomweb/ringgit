<?php

use Duit\MYR;
use Money\Money;
use PHPUnit\Framework\TestCase;

class MYRTest extends TestCase
{
    /** @test */
    public function it_can_be_initiated_using_given()
    {
        $money = MYR::given(500);

        $this->assertSame('500', $money->getAmount());
    }

    /** @test */
    public function it_can_be_initiated_using_parse()
    {
        $money = MYR::parse('2.50');

        $this->assertSame('250', $money->getAmount());
    }

    /** @test */
    public function it_can_be_get_currency_information()
    {
        $money = new MYR(500);

        $this->assertInstanceOf('Money\Currency', $money->getCurrency());
        $this->assertSame('MYR', $money->getCurrency()->getCode());
    }

    /** @test */
    public function it_can_be_equaled()
    {
        $money = new MYR(500);
        $compared = Money::MYR(500);

        $stub = $money->equals($compared);

        $this->assertSame('2000', $stub->getAmount());
    }

    /** @test */
    public function it_can_be_added()
    {
        $money = new MYR(500);
        $compared = Money::MYR(500);

        $stub = $money->add($compared);

        $this->assertInstanceOf('Duit\MYR', $stub);
        $this->assertSame('1000', $stub->getAmount());
    }

    /** @test */
    public function it_can_be_subtracted()
    {
        $money = new MYR(1000);
        $compared = Money::MYR(300);

        $stub = $money->subtract($compared);

        $this->assertInstanceOf('Duit\MYR', $stub);
        $this->assertSame('700', $stub->getAmount());
    }

    /** @test */
    public function it_can_be_multiplied()
    {
        $money = new MYR(1000);

        $stub = $money->multiply(2);

        $this->assertInstanceOf('Duit\MYR', $stub);
        $this->assertSame('2000', $stub->getAmount());
    }

    /** @test */
    public function it_can_be_divided()
    {
        $money = new MYR(1000);

        $stub = $money->divide(2);

        $this->assertInstanceOf('Duit\MYR', $stub);
        $this->assertSame('500', $stub->getAmount());
    }

    /** @test */
    public function it_immutable_between_operation()
    {
        $money = new MYR(1000);

        $this->assertSame('1530', $money->add(new MYR(530))->getAmount());
        $this->assertSame('470', $money->subtract(new MYR(530))->getAmount());
        $this->assertSame('2000', $money->multiply(2)->getAmount());
        $this->assertSame('500', $money->divide(2)->getAmount());

        $this->assertSame('2925', $money->add(new MYR(1500))->subtract(new MYR(550))->multiply(3)->divide(2)->getAmount());
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    public function it_can_call_undefined_method()
    {
        (new MYR(500))->foobar();
    }

    /** @test */
    public function it_can_be_converted_to_json()
    {
        $money = MYR::given(1124);

        $this->assertSame('{"amount":"1124","cash":"1125","vat":"0","amount_with_vat":"1124","cash_with_vat":"1125","currency":"MYR"}', json_encode($money));
    }
}
