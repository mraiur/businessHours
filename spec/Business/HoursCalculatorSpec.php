<?php

namespace spec\Business;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HoursCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Business\HoursCalculator');
    }
}
