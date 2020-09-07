<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use TheRedDot\MonologExtraBundle\Logger\Command\CommandLoggerInterface;

class ConsoleCommandListener
{
    /**
     * @var CommandLoggerInterface
     */
    protected $commandLogger;

    public function __construct(CommandLoggerInterface $commandLogger)
    {
        $this->commandLogger = $commandLogger;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        if (null === $event->getCommand()) {
            return;
        }

        $this->commandLogger->logCommand($event->getCommand(), $event->getInput(), $event->getOutput());
    }
}
