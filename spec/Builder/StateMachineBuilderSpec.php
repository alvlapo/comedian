<?php

namespace spec\Rotoscoping\Comedian\Builder;

use Rotoscoping\Comedian\StateMachine;
use Rotoscoping\Comedian\Builder\StateMachineBuilder;
use Rotoscoping\Comedian\Builder\StateMachineBuilderInterface;
use Rotoscoping\Comedian\Error\MissingImplementation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateMachineBuilderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(StateMachine::class);
    }

    function it_is_initializable()
    {
        $this->shouldImplement(StateMachineBuilderInterface::class);
    }

    function it_should_not_initialize_with_no_exists_class()
    {
        $this
            ->shouldThrow(MissingImplementation::class)
            ->duringInstantiation()
            ->beConstructedWith('Rotoscoping\Comedian\NotExists');
    }

    function it_should_add_state(SimpleState $state)
    {
        $state->getName()->shouldBeCalled()->willReturn('state');
        $state->getType()->shouldBeCalled()->willReturn(SimpleState::INITIAL);

        $this->addState($state)->shouldReturnAnInstanceOf(StateMachineBuilder::class);
    }

    function it_should_add_state_set(StateSet $stateSet)
    {
        $stateSet->validate()->shouldBeCalled()->willReturn(true);

        $this->addStateSet($stateSet)->shouldReturnAnInstanceOf(StateMachineBuilder::class);
    }

    function it_should_set_machine_name()
    {
        $this->setName('name')->shouldReturnAnInstanceOf(StateMachineBuilder::class);
    }

    function it_should_set_context(SimpleContext $context)
    {
        $this->setContext($context)->shouldReturnAnInstanceOf(StateMachineBuilder::class);
    }

    function is_should_not_allow_build_machine_without_structure()
    {
        $this->shouldThrow(InvalidStructure::class)->during('build');
    }
}
