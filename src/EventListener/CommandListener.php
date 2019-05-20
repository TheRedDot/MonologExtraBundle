<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

use TheRedDot\MonologExtraBundle\Logger\Command\CommandLoggerInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class CommandListener
{
    /**
     * @var CommandLoggerInterface
     */
    protected $commandLogger;

    public function __construct(CommandLoggerInterface $commandLogger)
    {
        $this->commandLogger = $commandLogger;
    }

    public function onCommandResponse(ConsoleCommandEvent $event): void
    {
        $this->commandLogger->logCommand($event->getCommand(), $event->getInput(), $event->getOutput());
    }
}
