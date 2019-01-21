<?php

namespace spec\Rotoscoping\Comedian\State;

use PhpSpec\ObjectBehavior;
use Rotoscoping\Comedian\State\BaseState;
use Rotoscoping\Comedian\State\NormalState;
use Rotoscoping\Comedian\State\StateInterface;

class BaseStateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(NormalState::class);
        $this->beConstructedWith('name');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BaseState::class);
    }

    function it_is_a_state()
    {
        $this->shouldImplement(StateInterface::class);
    }

    function it_should_get_name()
    {
        $this->getName()->shouldReturn('name');
    }

    function it_should_get_state_type()
    {
        $this->getType()->shouldReturn(StateInterface::NORMAL_STATE);
    }

    function it_should_add_event_with_boolean_return_value()
    {
        $this->event('publish', true)->shouldReturnAnInstanceOf(BaseState::class);
        $this->publish()->shouldReturn(true);
    }

    function it_should_add_event_with_string_return_value()
    {
        $this->event('publish', 'published')->shouldReturnAnInstanceOf(BaseState::class);
        $this->publish()->shouldReturn('published');
    }

    function it_should_add_event_with_callable_return_value()
    {
        $this->event('publish', function () { return 'clojure'; })->shouldReturnAnInstanceOf(BaseState::class);
        $this->publish()->shouldReturn('clojure');
    }

    function it_should_add_trigger()
    {
        $this->trigger('onExit', function () { return true; })->shouldReturnAnInstanceOf(BaseState::class);

        $this->onExit()->shouldBeBoolean();
    }

    function it_should_have_before_trigger()
    {
        $this->event('publish', true);
        $this->trigger('beforePublish', function () { return 'before'; });

        $this->beforePublish()->shouldBe('before');
    }

    function it_should_have_after_trigger()
    {
        $this->event('publish', true);
        $this->trigger('afterPublish', function () { return 'after'; });

        $this->afterPublish()->shouldBe('after');
    }
}
