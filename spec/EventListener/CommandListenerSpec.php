<?php

namespace spec\TheRedDot\MonologExtraBundle\EventListener;

use TheRedDot\MonologExtraBundle\EventListener\CommandListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TheRedDot\MonologExtraBundle\Logger\Command\CommandLoggerInterface;

class CommandListenerSpec extends ObjectBehavior
{
    function let(CommandLoggerInterface $commandLogger)
    {
        $this->beConstructedWith($commandLogger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommandListener::class);
    }
}
