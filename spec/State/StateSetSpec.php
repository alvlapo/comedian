<?php

namespace spec\Rotoscoping\Comedian\State;

use Rotoscoping\Comedian\State\StateSet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateSetSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            SimpleState::normal('stateA'),
            SimpleState::normal('stateB')
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StateSet::class);
        $this->shouldImplement(\Countable::class);
    }

    function it_should_add_only_status_objects()
    {
        $this->shouldThrow(InvalidStructure::class)->during('append', ['state']);
    }

    function it_should_not_allow_add_more_than_one_initial_state(SimpleState $state)
    {
        $state->getName()->shouldBeCalled()->willReturn('stateC');
        $state->getType()->shouldBeCalled()->willReturn(SimpleState::INITIAL);

        $this->append($state);

        $this->shouldThrow(InvalidStructure::class)->during('append', [$state]);
    }

    function it_should_not_validate_without_at_least_one_final_state()
    {
        $this->validate()->shouldBeBoolean();
        $this->validate()->shouldReturn(false);
    }

    function it_should_not_validate_without_an_initial_state()
    {
        $this->validate()->shouldBeBoolean();
        $this->validate()->shouldReturn(false);
    }

    function it_should_append_state(SimpleState $state)
    {
        $state->getName()->shouldBeCalled()->willReturn('stateC');
        $state->getType()->shouldBeCalled()->willReturn(SimpleState::INITIAL);

        $this->append($state)->shouldReturnAnInstanceOf(StateSet::class);
        $this->count()->shouldReturn(3);
    }

    function it_should_remove_state()
    {
        $this->remove('stateA')->shouldBeBoolean();
        $this->count()->shouldReturn(1);
    }

    function it_should_get_initial_status(SimpleState $state)
    {
        $state->getName()->shouldBeCalled()->willReturn('stateC');
        $state->getType()->shouldBeCalled()->willReturn(SimpleState::INITIAL);

        $this->append($state);

        $this->getInitial()->shouldReturn($state);
    }

    function it_should_check_for_the_initial_status()
    {
        $this->hasInitial()->shouldBeBoolean();
    }

    function it_should_return_null_when_the_initial_status_is_not_defined()
    {
        $this->getInitial()->shouldBeNull();
    }

    function it_should_get_final_status(SimpleState $state)
    {
        $state->getName()->shouldBeCalled()->willReturn('stateD');
        $state->getType()->shouldBeCalled()->willReturn(SimpleState::FINAL);

        $this->add($state);

        $this->getFinal()->shouldReturn($state);
    }

    function it_should_check_for_the_final_status()
    {
        $this->hasFinal()->shouldBeBoolean();
    }

    function it_should_return_null_when_the_final_status_is_not_defined()
    {
        $this->getFinal()->shouldBeNull();
    }

    function it_should_check_for_the_normal_status()
    {
        $this->hasNormal()->shouldBeBoolean();
    }

    function it_should_return_null_when_the_normal_status_is_not_defined()
    {
        $this->beConstructedWith();

        $this->getNormal()->shouldBeNull();
    }

    function it_should_get_all_status()
    {
        $this->getAll()->shouldBeArray();
    }

    function it_should_get_status_by_name()
    {
        $this->get('stateA')->shouldReturnAnInstanceOf(SimpleState::class);
        $this->get('stateM')->shouldBeNull();
    }

    function it_should_check_for_the_status()
    {
        $this->has('stateA')->shouldBeBoolean();
        $this->has('stateM')->shouldBeBoolean();
    }
}
