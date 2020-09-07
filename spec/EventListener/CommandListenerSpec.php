<?php

namespace spec\TheRedDot\MonologExtraBundle\EventListener;

use PhpSpec\ObjectBehavior;
use TheRedDot\MonologExtraBundle\EventListener\ConsoleCommandListener;
use TheRedDot\MonologExtraBundle\Logger\Command\CommandLoggerInterface;

class CommandListenerSpec extends ObjectBehavior
{
    public function let(CommandLoggerInterface $commandLogger)
    {
        $this->beConstructedWith($commandLogger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ConsoleCommandListener::class);
    }
}
