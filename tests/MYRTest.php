<?php

use Duit\MYR;
use PHPUnit\Framework\TestCase;

class MYRTest extends TestCase
{
    /** @test */
    public function it_can_be_added()
    {
        $money = new MYR(500);

        $this->assertSame('1000', $money->add($money)->getAmount());
    }

    /** @test */
    public function it_can_be_subtracted()
    {
        $money = new MYR(1000);

        $this->assertSame('700', $money->subtract(new MYR(300))->getAmount());
    }

    /** @test */
    public function it_can_be_multiplied()
    {
        $money = new MYR(1000);

        $this->assertSame('2000', $money->multiply(2)->getAmount());
    }

    /** @test */
    public function it_can_be_divided()
    {
        $money = new MYR(1000);

        $this->assertSame('500', $money->divide(2)->getAmount());
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    public function it_can_call_undefined_method()
    {
        (new MYR(500))->foobar();
    }
}
