<?php

namespace spec\TheRedDot\MonologExtraBundle\EventListener;

use TheRedDot\MonologExtraBundle\EventListener\RequestResponseListener;
use PhpSpec\ObjectBehavior;
use TheRedDot\MonologExtraBundle\Logger\Request\RequestLoggerInterface;
use TheRedDot\MonologExtraBundle\Logger\Response\ResponseLoggerInterface;

class RequestResponseListenerSpec extends ObjectBehavior
{
    public function let(RequestLoggerInterface $requestLogger, ResponseLoggerInterface $responseLogger)
    {
        $this->beConstructedWith($requestLogger, $responseLogger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RequestResponseListener::class);
    }
}
