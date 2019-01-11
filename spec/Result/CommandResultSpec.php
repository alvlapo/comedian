<?php

namespace spec\Rotoscoping\Comedian\Result;

use Rotoscoping\Comedian\Result\CommandResult;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandResultSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CommandResult::class);
        $this->shouldImplement(ResultInterface::class);
    }

    function it_is_successful()
    {
        $this->beConstructedThrough('success');
        $this->isSuccess()->shouldReturn(true);
    }

    function it_is_aborted()
    {
        $this->beConstructedThrough('abort');
        $this->isAbort()->shouldReturn(true);
    }

    function it_is_errored()
    {
        $this->beConstructedThrough('error');
        $this->isError()->shouldReturn(true);
    }

    function it_should_get_status()
    {
        $this->getStatus()->shouldBeInteger();
    }

    function it_should_set_status()
    {
        $this->setStatus(ResultInterface::SUCCESS)->shouldReturnAnInstanceOf(CommandInterface::class);
    }

    function it_should_get_state()
    {
        $this->getState()->shouldReturnAnInstanceOf(StateInterface::class);
    }

    function it_should_get_command()
    {
        $this->getCommand()->shouldReturnAnInstanceOf(CommandInterface::class);
    }

    function it_should_get_params()
    {
        $this->getParams()->shouldBeArray();
    }

    function it_should_set_state(State $state)
    {
        $this->setState($state)->shouldReturnAnInstanceOf(CommandResult::class);
    }

    function it_should_set_command(TransitionCommand $command)
    {
        $this->setCommand($command)->shouldReturnAnInstanceOf(CommandResult::class);
    }

    function it_should_set_params()
    {
        $this->setParams(['param' => 1])->shouldReturnAnInstanceOf(CommandResult::class);
    }
}
