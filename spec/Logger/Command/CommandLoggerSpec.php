<?php

namespace spec\TheRedDot\MonologExtraBundle\Logger\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TheRedDot\MonologExtraBundle\Logger\Command\CommandLogger;
use TheRedDot\MonologExtraBundle\Logger\Command\CommandLoggerInterface;

class CommandLoggerSpec extends ObjectBehavior
{
    public function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CommandLogger::class);
    }

    public function it_implements_command_logger_interface()
    {
        $this->shouldImplement(CommandLoggerInterface::class);
    }

    public function it_logs_command(LoggerInterface $logger, Command $command, InputInterface $input, OutputInterface $output)
    {
        $logger
            ->info(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled();

        $this->logCommand($command, $input, $output);
    }
}
