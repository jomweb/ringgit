<?php

namespace Duit\Tests\Taxable;

use Duit\Taxable\Gst;
use Duit\Contracts\Taxable;
use Duit\Taxable\Gst\ZeroRate;
use PHPUnit\Framework\TestCase;

class ZeroRateTest extends TestCase
{
    /** @test */
    public function it_define_proper_signature()
    {
        $stub = new ZeroRate();

        $this->assertInstanceOf(Taxable::class, $stub);
        $this->assertInstanceOf(Gst::class, $stub);
        $this->assertSame('GST:ZR', $stub->taxCode());
        $this->assertSame(0.0, $stub->taxRate());
    }
}
