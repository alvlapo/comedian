<?php

namespace spec\Rotoscoping\Comedian\State;

use PhpSpec\ObjectBehavior;
use Rotoscoping\Comedian\State\InitialState;
use Rotoscoping\Comedian\State\StateInterface;

class InitialStateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('state');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InitialState::class);
    }

    function it_is_a_state()
    {
        $this->shouldImplement(StateInterface::class);
    }

    function it_is_should_have_initial_type()
    {
        $this->getType()->shouldReturn(StateInterface::INITIAL_STATE);
    }
}
