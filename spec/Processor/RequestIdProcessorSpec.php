<?php

namespace spec\Hexanet\Common\MonologExtraBundle\Processor;

use Hexanet\Common\MonologExtraBundle\Processor\RequestIdProcessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Hexanet\Common\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;

class RequestIdProcessorSpec extends ObjectBehavior
{
    function let(RequestIdProviderInterface $requestIdProvider)
    {
        $this->beConstructedWith($requestIdProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RequestIdProcessor::class);
    }

    function it_adds_uniq_request_id_to_record(RequestIdProviderInterface $requestIdProvider)
    {
        $requestIdProvider
            ->getRequestId()
            ->willReturn('qs5df4qsd4fqs4df5qs4df8s5d');

        $this->processRecord(['message' => 'test log'])->shouldReturn([
            'message' => 'test log',
            'extra' => [
                'request_id' => 'qs5df4qsd4fqs4df5qs4df8s5d'
            ]
        ]);
    }
}
