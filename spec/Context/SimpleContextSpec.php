<?php

namespace spec\Rotoscoping\Comedian\Context;

use PhpSpec\ObjectBehavior;
use Rotoscoping\Comedian\Context\ContextInterface;
use Rotoscoping\Comedian\Context\SimpleContext;

class SimpleContextSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith();

        $this->addProperty('prop_1', 1);
        $this->addProperty('prop_2', 2);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(SimpleContext::class);
    }

    function it_is_a_context()
    {
        $this->shouldImplement(ContextInterface::class);
    }

    function it_should_get_current_state()
    {
        $this->getState()->shouldBeNull();
    }

    function it_should_set_current_state()
    {
        $this->setState('draft')->shouldBeBoolean();
        $this->getState()->shouldReturn('draft');
    }

    function it_should_get_property_by_name()
    {
        $this->getProperty('prop_1')->shouldBe(1);
    }

    function it_should_get_all_properties()
    {
        $this->getProperties()->shouldBeArray();
        $this->getProperties()->shouldHaveCount(2);
    }

    function it_should_add_property()
    {
        $this->addProperty('property', 'value')->shouldBeBoolean();
        $this->getProperties()->shouldHaveCount(3);
        $this->getProperties()->shouldContain('value');
    }

    function it_should_delete_property()
    {
        $this->deleteProperty('prop_2')->shouldBeBoolean();

        $this->getProperties()->shouldHaveCount(1);
        $this->getProperties()->shouldNotContain(2);
    }
}
