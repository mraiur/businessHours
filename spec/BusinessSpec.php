<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BusinessSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Business');
    }
}
