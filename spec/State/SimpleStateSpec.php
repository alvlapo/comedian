<?php

namespace spec\Rotoscoping\Comedian;

use Rotoscoping\Comedian\State;
use Rotoscoping\Comedian\State\StateInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleStateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('name', SimpleState::NORMAL);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(State::class);
        $this->shouldImplement(StateInterface::class);
    }

    function it_should_get_name()
    {
        $this->getName()->shouldBeString();
    }

    function it_should_get_state_type()
    {
        $this->getType()->shouldBeInteger();
    }

    function it_is_should_be_construct_as_initial_state()
    {
        $this->beConstructedThrough('initial', ['state']);

        $this->getType()->shouldReturn(State::INITIAL);
        $this->getName()->shouldReturn('state');
    }

    function it_is_should_be_construct_as_normal_state()
    {
        $this->beConstructedThrough('normal', ['state']);

        $this->getType()->shouldReturn(State::NORMAL);
        $this->getName()->shouldReturn('state');
    }

    function it_is_should_be_construct_as_final_state()
    {
        $this->beConstructedWith('state', State::FINAL);
        $this->beConstructedThrough('final', ['state']);

        $this->getType()->shouldReturn(State::FINAL);
        $this->getName()->shouldReturn('state');
    }

    function it_should_add_event_with_boolean_return_value()
    {
        $this->event('publish', true)->shouldReturnAnInstanceOf(State::class);
        $this->publish()->shouldReturn(true);
    }

    function it_should_add_event_with_string_return_value()
    {
        $this->event('publish', 'published')->shouldReturnAnInstanceOf(State::class);
        $this->publish()->shouldReturn('published');
    }

    function it_should_add_event_with_callable_return_value()
    {
        $this->event('publish', function ($machine) { return true; })->shouldReturnAnInstanceOf(State::class);
        $this->publish()->shouldBeCallable();
    }

    function it_should_add_trigger()
    {
        $this->trigger('onExit', function ($machine) { return true; })->shouldReturnAnInstanceOf(State::class);
    }
}
