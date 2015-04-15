<?php

namespace spec\Business;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DaysOfWeekSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Business\DaysOfWeek');
    }
}
