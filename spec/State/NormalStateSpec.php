<?php

namespace spec\Rotoscoping\Comedian\State;

use PhpSpec\ObjectBehavior;
use Rotoscoping\Comedian\State\NormalState;
use Rotoscoping\Comedian\State\StateInterface;

class NormalStateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('state');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NormalState::class);
    }

    function it_is_a_state()
    {
        $this->shouldImplement(StateInterface::class);
    }

    function it_is_should_have_initial_type()
    {
        $this->getType()->shouldReturn(StateInterface::NORMAL_STATE);
    }
}
