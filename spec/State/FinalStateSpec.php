<?php

namespace spec\Rotoscoping\Comedian\State;

use PhpSpec\ObjectBehavior;
use Rotoscoping\Comedian\State\FinalState;
use Rotoscoping\Comedian\State\StateInterface;

class FinalStateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('state');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FinalState::class);
    }

    function it_is_a_state()
    {
        $this->shouldImplement(StateInterface::class);
    }

    function it_is_should_have_initial_type()
    {
        $this->getType()->shouldReturn(StateInterface::FINAL_STATE);
    }
}
