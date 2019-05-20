<?php

namespace TheRedDot\MonologExtraBundle\Logger\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandLogger implements CommandLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logCommand(Command $command, InputInterface $input, OutputInterface $output) : void
    {
        $msg = sprintf(
            'Command "%s"',
            $command->getName()
        );

        $this->logger->info($msg, $this->createContexts($command, $input, $output));
    }

    public function createContexts(Command $command, InputInterface $input, OutputInterface $output) : array
    {
        $map = array(
            'command_name' => $command->getName(),
            'command_enabled' => $command->isEnabled(),
            'command_hidden' => $command->isHidden(),
            'command_debug' => $output->isDebug(),
            'command_options' => $input->getOptions(),
            'command_arguments' => $input->getArguments(),
        );

        return $map;
    }

}
