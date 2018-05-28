<?php

namespace Duit\Tests\Taxable;

use Duit\Taxable\Gst;
use Duit\Contracts\Taxable;
use PHPUnit\Framework\TestCase;
use Duit\Taxable\Gst\StandardRate;

class StandardRateTest extends TestCase
{
    /** @test */
    public function it_define_proper_signature()
    {
        $stub = new StandardRate();

        $this->assertInstanceOf(Taxable::class, $stub);
        $this->assertInstanceOf(Gst::class, $stub);
        $this->assertSame('GST:SR', $stub->taxCode());
        $this->assertSame(0.06, $stub->taxRate());
    }
}
