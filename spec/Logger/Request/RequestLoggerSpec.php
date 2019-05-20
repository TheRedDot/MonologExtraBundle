<?php

namespace spec\TheRedDot\MonologExtraBundle\Logger\Request;

use TheRedDot\MonologExtraBundle\Logger\Request\RequestLogger;
use TheRedDot\MonologExtraBundle\Logger\Request\RequestLoggerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class RequestLoggerSpec extends ObjectBehavior
{
    public function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RequestLogger::class);
    }

    public function it_implements_request_logger_interface()
    {
        $this->shouldImplement(RequestLoggerInterface::class);
    }

    public function it_logs_request(LoggerInterface $logger, Request $request, ParameterBag $parameterBag)
    {
        $logger
            ->info(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled();

        $request->attributes = $parameterBag;

        $this->logRequest($request);
    }
}
