<?php

namespace spec\Rotoscoping\Comedian\State;

use PhpSpec\ObjectBehavior;
use Rotoscoping\Comedian\State\NormalState;
use Rotoscoping\Comedian\State\StateInterface;
use Rotoscoping\Comedian\State\StateSet;

class StateSetSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new NormalState('stateA'),
            new NormalState('stateB')
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StateSet::class);
    }

    function it_is_a_countable()
    {
        $this->shouldImplement(\Countable::class);
    }

    function it_should_add_state(StateInterface $state)
    {
        $state->getName()->shouldBeCalled()->willReturn('stateC');
        $state->getType()->shouldBeCalled()->willReturn(StateInterface::INITIAL_STATE);

        $this->add($state)->shouldReturnAnInstanceOf(StateSet::class);
        $this->count()->shouldReturn(3);
    }

    function it_should_remove_state()
    {
        $this->remove('stateA')->shouldBeBoolean();
        $this->count()->shouldReturn(1);
    }

    function it_should_get_initial_status(StateInterface $state)
    {
        $state->getName()->shouldBeCalled()->willReturn('stateC');
        $state->getType()->shouldBeCalled()->willReturn(StateInterface::INITIAL_STATE);

        $this->add($state);

        $this->getInitial()->shouldContain($state);
    }

    function it_should_check_for_the_initial_status()
    {
        $this->hasInitial()->shouldBe(false);
    }

    function it_should_return_null_when_the_initial_status_is_not_defined()
    {
        $this->getInitial()->shouldBeNull();
    }

    function it_should_get_final_status(StateInterface $state)
    {
        $state->getName()->shouldBeCalled()->willReturn('stateD');
        $state->getType()->shouldBeCalled()->willReturn(StateInterface::FINAL_STATE);

        $this->add($state);

        $this->getFinal()->shouldContain($state);
    }

    function it_should_check_for_the_final_status()
    {
        $this->hasFinal()->shouldBe(false);
    }

    function it_should_return_null_when_the_final_status_is_not_defined()
    {
        $this->getFinal()->shouldBeNull();
    }

    function it_should_check_for_the_normal_status()
    {
        $this->hasNormal()->shouldBe(true);
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
        $this->get('stateA')->shouldReturnAnInstanceOf(StateInterface::class);
        $this->get('stateM')->shouldBeNull();
    }

    function it_should_check_for_the_status()
    {
        $this->has('stateA')->shouldBe(true);
        $this->has('stateM')->shouldBe(false);
    }
}
