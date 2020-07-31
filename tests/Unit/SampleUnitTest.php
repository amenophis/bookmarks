<?php

declare(strict_types=1);

namespace Unit\App;

use App\Kernel;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class SampleUnitTest extends TestCase
{
    use ProphecyTrait;

    public function testSample(): void
    {
        $kernelProphecy = $this->prophesize(Kernel::class);
        $kernelProphecy->getProjectDir()->shouldBeCalled()->willReturn('123');

        $kernel = $kernelProphecy->reveal();

        $this->assertEquals('123', $kernel->getProjectDir());
    }
}
