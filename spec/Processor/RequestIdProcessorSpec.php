<?php

namespace spec\TheRedDot\MonologExtraBundle\Processor;

use PhpSpec\ObjectBehavior;
use TheRedDot\MonologExtraBundle\Processor\RequestIdProcessor;
use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;

class RequestIdProcessorSpec extends ObjectBehavior
{
    public function let(RequestIdProviderInterface $requestIdProvider)
    {
        $this->beConstructedWith($requestIdProvider);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RequestIdProcessor::class);
    }

    public function it_adds_uniq_request_id_to_record(RequestIdProviderInterface $requestIdProvider)
    {
        $requestIdProvider
            ->getRequestId()
            ->willReturn('qs5df4qsd4fqs4df5qs4df8s5d');

        $this->processRecord(['message' => 'test log'])->shouldReturn([
            'message' => 'test log',
            'extra' => [
                'request_id' => 'qs5df4qsd4fqs4df5qs4df8s5d',
            ],
        ]);
    }
}
