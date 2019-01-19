<?php

namespace spec\Rotoscoping\Comedian\Context;

use Rotoscoping\Comedian\Context\SimpleContext;
use Rotoscoping\Comedian\Context\ContextInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleContextSpec extends ObjectBehavior
{
    function it_is_initializable()
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
    }

    function it_should_get_property_by_name()
    {
        $this->getProperty('property')->shouldBeString();
    }

    function it_should_get_all_properties()
    {
        $this->getProperties()->shouldBeArray();
    }

    function it_should_add_property()
    {
        $this->addProperty('property', 'value')->shouldBeBoolean();
    }

    function it_should_delete_property()
    {
        $this->deleteProperty('property')->shouldBeBoolean();
    }
}
