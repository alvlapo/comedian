<?php

namespace spec\Rotoscoping\Comedian;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Rotoscoping\Comedian\StateMachine;
use Rotoscoping\Comedian\State\StateSet;
use Rotoscoping\Comedian\State\FinalState;
use Rotoscoping\Comedian\State\NormalState;
use Rotoscoping\Comedian\State\InitialState;
use Rotoscoping\Comedian\Error\ExecutionError;
use Rotoscoping\Comedian\Context\SimpleContext;
use Rotoscoping\Comedian\Result\OperationResult;
use Rotoscoping\Comedian\Operation\Factory as OperationFactory;

/**
 * @require Rotoscoping\Comedian\StateMachine
 */
class StateMachineSpec extends ObjectBehavior
{
    function let()
    {
        $states = new StateSet(
            (new InitialState('draft'))
                ->event('submit', 'submitted')
                ->event('self', 'draft') // not allowed
                ->event('unknown', function () { return OperationFactory::apply('foobar');}), // unknown state
            (new NormalState('submitted'))
                ->event('reject', 'rejected')
                ->event('approve', 'processing'),
            (new NormalState('processing'))
                ->event('process', 'processing') // self transition
                ->event('close', 'closed'),
            (new FinalState('rejected'))
                ->event('self', 'close'), // not allowed
            (new FinalState('closed'))
        );

        $context = new SimpleContext('draft');
        $context->addProperty('owner', 'username');

        $this->beConstructedWith('machine', $context, $states);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StateMachine::class);
    }

    function it_should_get_machine_name()
    {
        $this->getMachineName()->shouldBeString();
    }

    function it_should_get_context()
    {
        $context = new SimpleContext('draft');

        $this->beConstructedWith('machine', $context);
        $this->getContext()->shouldReturn($context);
    }

    function it_should_set_context(SimpleContext $context)
    {
        $this->setContext($context)->shouldReturnAnInstanceOf(StateMachine::class);
    }

    function it_should_add_state_to_machine()
    {
        $this->addState(new NormalState('processing'))->shouldReturnAnInstanceOf(StateMachine::class);
    }

    function it_should_get_current_state()
    {
        $state = new NormalState('idle');
        $states = new StateSet($state);
        $context = new SimpleContext('idle');

        $this->beConstructedWith('machine', $context, $states);

        $this->getState()->shouldReturn($state);
    }

    /**
     * @require Rotoscoping\Comedian\Command\CommandResult
     */
    function it_should_execute_event_from_state()
    {
        $this->submit()->shouldReturnAnInstanceOf(CommandResult::class);
    }

    /**
     * @require Rotoscoping\Comedian\Error\ExecutionError
     */
    function it_should_not_allow_call_unknown_state_handler()
    {
        $this->shouldThrow(ExecutionError::class)->during('close');
    }

    /**
     * @require Rotoscoping\Comedian\Error\ExecutionError
     * @require Rotoscoping\Comedian\Command\CommandResult
     */
    function it_should_not_allow_self_transition_on_start_or_finish_states()
    {
        $this->shouldThrow(ExecutionError::class)->during('self');

        $this->submit()->shouldBeAnInstanceOf(CommandResult::class);
        $this->reject()->shouldBeAnInstanceOf(CommandResult::class);

        $this->shouldThrow(ExecutionError::class)->during('self');
    }

    /**
     * @require Rotoscoping\Comedian\Error\ExecutionError
     */
    function it_should_not_allow_transition_to_unknown_state()
    {
        $this->shouldThrow(ExecutionError::class)->during('unknown');
    }

    function it_should_get_properties_from_context()
    {
        $this->owner->shouldReturn('username');
    }

    function it_should_change_properties_to_context()
    {
        $this->owner = 'unknown';
        $this->owner->shouldReturn('unknown');
    }

    function it_should_add_properties_to_context()
    {
        $this->group = 'admins';
        $this->group->shouldReturn('admins');
    }
}
