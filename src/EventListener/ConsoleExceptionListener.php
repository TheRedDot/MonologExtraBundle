<?php

namespace Hexanet\Common\MonologExtraBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Psr\Log\LoggerInterface;

class ConsoleExceptionListener
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onConsoleException(ConsoleErrorEvent $event) : void
    {
        $command = $event->getCommand();
        if (!$command) {
            return;
        }

        $exception = $event instanceof ConsoleErrorEvent ? $event->getError() : $event->getException();

        $message = sprintf(
            '%s: %s (uncaught exception) at %s line %s while running console command `%s`',
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $command->getName()
        );

        $this->logger->error($message, [
            'exception' => $exception
        ]);
    }
}