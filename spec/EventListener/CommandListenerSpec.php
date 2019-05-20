<?php

namespace spec\TheRedDot\MonologExtraBundle\EventListener;

use TheRedDot\MonologExtraBundle\EventListener\CommandListener;
use PhpSpec\ObjectBehavior;
use TheRedDot\MonologExtraBundle\Logger\Command\CommandLoggerInterface;

class CommandListenerSpec extends ObjectBehavior
{
    public function let(CommandLoggerInterface $commandLogger)
    {
        $this->beConstructedWith($commandLogger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CommandListener::class);
    }
}
