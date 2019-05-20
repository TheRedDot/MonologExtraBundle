<?php

namespace spec\TheRedDot\MonologExtraBundle\Processor;

use TheRedDot\MonologExtraBundle\Processor\SessionIdProcessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TheRedDot\MonologExtraBundle\Provider\Session\SessionIdProviderInterface;

class SessionIdProcessorSpec extends ObjectBehavior
{
    function let(SessionIdProviderInterface $sessionIdProvider)
    {
        $this->beConstructedWith($sessionIdProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SessionIdProcessor::class);
    }

    function it_adds_session_id_to_record(SessionIdProviderInterface $sessionIdProvider)
    {
        $sessionIdProvider
            ->getSessionId()
            ->willReturn('sd65fg465sdfg46sd4fg65sdf');

        $this->processRecord(['message' => 'test log'])->shouldReturn([
            'message' => 'test log',
            'extra' => [
                'session_id' => 'sd65fg465sdfg46sd4fg65sdf'
            ]
        ]);
    }
}
