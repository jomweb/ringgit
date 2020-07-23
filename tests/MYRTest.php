<?php

namespace Duit\Tests;

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
        $this->assertFalse($money->hasTax());
        $this->assertNull($money->getTax());
    }

    /** @test */
    public function it_can_be_initiated_using_parse()
    {
        $money = MYR::parse('2.50');

        $this->assertSame('250', $money->getAmount());
    }

    /** @test */
    public function it_can_be_initiated_using_parse_from_encoded_myr()
    {
        $json = '{"amount":"2.50","currency":"MYR"}';
        $money = MYR::parse(json_decode($json, true));

        $this->assertSame('250', $money->getAmount());
    }

    /** @test */
    public function it_cant_be_initiated_using_parse_from_invalid_encoded_myr()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Unable to parse invalid $value');

        $json = '{"amount":"2.50"}';
        $money = MYR::parse(json_decode($json, true));

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
    public function it_can_determine_is_equals()
    {
        $money = new MYR(500);
        $compared = Money::MYR(500);

        $stub = $money->equals($compared);

        $this->assertTrue($stub);

        $this->assertFalse((new MYR(500))->equals(new MYR(300)));
    }

    /** @test */
    public function it_can_determine_is_same_currency()
    {
        $money = new MYR(500);
        $compared = Money::MYR(800);

        $stub = $money->isSameCurrency($compared);

        $this->assertTrue($stub);

        $money = new MYR(500);
        $compared = Money::USD(800);

        $stub = $money->isSameCurrency($compared);

        $this->assertFalse($stub);
    }

    /** @test */
    public function it_can_determine_is_less_than()
    {
        $money = new MYR(500);
        $compared = Money::MYR(1000);

        $stub = $money->lessThan($compared);

        $this->assertTrue($stub);

        $this->assertFalse((new MYR(1000))->lessThan(new MYR(500)));
    }

    /** @test */
    public function it_can_determine_is_less_than_or_equals()
    {
        $money = new MYR(500);
        $compared = Money::MYR(500);

        $stub = $money->lessThanOrEqual($compared);

        $this->assertTrue($stub);

        $this->assertFalse((new MYR(501))->equals(new MYR(500)));
    }

    /** @test */
    public function it_can_determine_is_greater_than()
    {
        $money = new MYR(1000);
        $compared = Money::MYR(500);

        $stub = $money->greaterThan($compared);

        $this->assertTrue($stub);

        $this->assertFalse((new MYR(500))->greaterThan(new MYR(1000)));
    }

    /** @test */
    public function it_can_determine_is_greater_than_or_equals()
    {
        $money = new MYR(500);
        $compared = Money::MYR(500);

        $stub = $money->greaterThanOrEqual($compared);

        $this->assertTrue($stub);

        $this->assertFalse((new MYR(500))->greaterThanOrEqual(new MYR(501)));
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
    public function it_can_determine_is_negative()
    {
        $money = new MYR(-100);

        $this->assertSame('-1.00', $money->amount());
        $this->assertSame('-100', $money->getAmount());

        $this->assertTrue($money->isNegative());
        $this->assertFalse($money->isZero());
        $this->assertFalse($money->isPositive());
    }

    /** @test */
    public function it_can_determine_is_zero()
    {
        $money = new MYR(0);

        $this->assertSame('0.00', $money->amount());
        $this->assertSame('0', $money->getAmount());

        $this->assertFalse($money->isNegative());
        $this->assertTrue($money->isZero());
        $this->assertFalse($money->isPositive());
    }

    /** @test */
    public function it_can_determine_is_positive()
    {
        $money = new MYR(100);

        $this->assertSame('1.00', $money->amount());
        $this->assertSame('100', $money->getAmount());

        $this->assertFalse($money->isNegative());
        $this->assertFalse($money->isZero());
        $this->assertTrue($money->isPositive());
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

    /** @test */
    public function it_can_call_undefined_method()
    {
        $this->expectException('BadMethodCallException');

        (new MYR(500))->foobar();
    }

    /** @test */
    public function it_can_be_converted_to_json()
    {
        $money = MYR::given(1124);

        $this->assertSame('{"amount":"1124","cash":"1125","tax":"0","tax_code":null,"tax_rate":null,"amount_with_tax":"1124","cash_with_tax":"1125","currency":"MYR"}', json_encode($money));
    }

    /** @test */
    public function it_can_be_allocated_without_tax()
    {
        $money = MYR::given(500);

        $allocation = $money->allocateWithTax([1, 1, 1]);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('167', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('0', $allocation[0]->getTaxAmount());
        $this->assertSame('0', $allocation[1]->getTaxAmount());
        $this->assertSame('0', $allocation[2]->getTaxAmount());

        $this->assertSame('167', $allocation[0]->getAmountWithTax());
        $this->assertSame('167', $allocation[1]->getAmountWithTax());
        $this->assertSame('166', $allocation[2]->getAmountWithTax());

        $this->assertFalse($allocation[0]->hasTax());
        $this->assertFalse($allocation[1]->hasTax());
        $this->assertFalse($allocation[2]->hasTax());
    }

    /** @test */
    public function it_can_be_allocated_with_gst_using_n()
    {
        $money = MYR::given(500);

        $allocation = $money->allocateWithTaxTo(3);

        $this->assertSame('167', $allocation[0]->getAmount());
        $this->assertSame('167', $allocation[1]->getAmount());
        $this->assertSame('166', $allocation[2]->getAmount());

        $this->assertSame('0', $allocation[0]->getTaxAmount());
        $this->assertSame('0', $allocation[1]->getTaxAmount());
        $this->assertSame('0', $allocation[2]->getTaxAmount());

        $this->assertSame('167', $allocation[0]->getAmountWithTax());
        $this->assertSame('167', $allocation[1]->getAmountWithTax());
        $this->assertSame('166', $allocation[2]->getAmountWithTax());

        $this->assertFalse($allocation[0]->hasTax());
        $this->assertFalse($allocation[1]->hasTax());
        $this->assertFalse($allocation[2]->hasTax());
    }
}
