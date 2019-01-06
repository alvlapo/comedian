<?php

namespace spec\Rotoscoping\Comedian;

use Rotoscoping\Comedian\StateMachine;
use Rotoscoping\Comedian\Result\OperationResult;
use Rotoscoping\Comedian\Error\ExecutionError;
use Rotoscoping\Comedian\Context\StateContext;
use Rotoscoping\Comedian\State\StateSet;
use Rotoscoping\Comedian\Param\Output;
use Rotoscoping\Comedian\State;
use Rotoscoping\Comedian\Operation\Factory as OperationFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateMachineSpec extends ObjectBehavior
{
    function let(StateContext $context, StateSet $states)
    {
        $states->append(
            State::initial('draft')
                ->event('submit', 'submitted')
                ->event('self', 'draft') // not allowed
                ->event('unknown', function () { return OperationFactory::apply('foobar');}), // unknown state
            State::normal('submitted')
                ->event('reject', 'rejected')
                ->event('approve', 'processing'),
            State::normal('processing')
                ->event('process', 'processing') // self transition
                ->event('close', 'closed'),
            State::finish('rejected')
                ->event('self', 'close'), // not allowed
            State::finish('closed')
        );

        $this->beConstructedWith('specName', $context, $states);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StateMachine::class);
    }

    function it_should_get_machine_name()
    {
        $this->getMachineName()->shouldBeString();
    }

    function it_should_get_current_state()
    {
        $this->getStateName()->shouldBeString();
    }

    function it_should_get_current_state_type()
    {
        $this->getStateType()->shouldBeString();
    }

    function it_should_execute_event_from_state()
    {
        $this->submit()->shouldReturnAnInstanceOf(Output::class);
    }

    function it_should_not_allow_call_unknown_state_handler()
    {
        $this->shouldThrow(ExecutionError::class)->during('close');
    }

    function it_should_not_allow_self_transition_on_start_or_finish_states()
    {
        $this->shouldThrow(ExecutionError::class)->during('self');

        $this->submit()->shouldBeAnInstanceOf(Output::class);
        $this->reject()->shouldBeAnInstanceOf(Output::class);

        $this->shouldThrow(ExecutionError::class)->during('self');
    }

    function it_should_not_allow_transition_to_unknown_state()
    {
        $this->shouldThrow(ExecutionError::class)->during('unknown');
    }
}
