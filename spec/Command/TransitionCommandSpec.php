<?php

namespace spec\Rotoscoping\Comedian\Command;

use Rotoscoping\Comedian\Command\TransitionCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransitionCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('state_b');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TransitionCommand::class);
        $this->shouldImplement(CommandInterface::class);
    }

    function it_is_should_get_state_to()
    {
        $this->getStateTo()->shouldBeString();
    }

    function it_is_runnable(StateMachine $machine, State $state)
    {
        $this->run($machine, $state)->shouldReturnAnInstanceOf(Result::class);
    }

    function it_should_not_allow_transition_to_missing_state(StateMachine $machine)
    {
        $stateSet = new StateSet(State::initial('stateA'), State::final('stateB'));
        $machine->getStates()->shouldBeCalled()->willReturn($stateSet);

        $this->beConstructedWith('stateC');
        $this->shouldThrow(InvalidStructure::class)->during('run', [$machine]);
    }
}
