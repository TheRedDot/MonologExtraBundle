<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleErrorEvent;
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

    public function onConsoleException(ConsoleErrorEvent $event): void
    {
        $command = $event->getCommand();
        if (null === $command) {
            return;
        }

        $exception = $event->getError();

        $message = sprintf(
            '%s: %s (uncaught exception) at %s line %s while running console command `%s`',
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $command->getName()
        );

        $this->logger->error($message, [
            'exception' => $exception,
        ]);
    }
}
