<?php

namespace spec\TheRedDot\MonologExtraBundle\Logger\Response;

use TheRedDot\MonologExtraBundle\Logger\Response\ResponseLogger;
use TheRedDot\MonologExtraBundle\Logger\Response\ResponseLoggerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponseLoggerSpec extends ObjectBehavior
{
    public function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ResponseLogger::class);
    }

    public function it_implements_response_logger_interface()
    {
        $this->shouldImplement(ResponseLoggerInterface::class);
    }

    public function it_logs_request(LoggerInterface $logger)
    {
        $logger
            ->info(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled();

        $request = new Request();
        $response = new Response();

        $this->logResponse($response, $request);
    }
}
