<?php

namespace spec\TheRedDot\MonologExtraBundle\EventListener;

use TheRedDot\MonologExtraBundle\EventListener\RequestResponseListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TheRedDot\MonologExtraBundle\Logger\Request\RequestLoggerInterface;
use TheRedDot\MonologExtraBundle\Logger\Response\ResponseLoggerInterface;

class RequestResponseListenerSpec extends ObjectBehavior
{
    function let(RequestLoggerInterface $requestLogger, ResponseLoggerInterface $responseLogger)
    {
        $this->beConstructedWith($requestLogger, $responseLogger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RequestResponseListener::class);
    }
}
