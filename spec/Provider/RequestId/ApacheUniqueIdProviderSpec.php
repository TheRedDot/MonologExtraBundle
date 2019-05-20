<?php

namespace spec\TheRedDot\MonologExtraBundle\Provider\Uid;

use TheRedDot\MonologExtraBundle\Provider\RequestId\ApacheUniqueIdProvider;
use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApacheUniqueIdProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ApacheUniqueIdProvider::class);
    }

    function it_implements_request_id_provider_interface()
    {
        $this->shouldImplement(RequestIdProviderInterface::class);
    }

    function it_returns_request_id()
    {
        $this->getRequestId()->shouldBeString();
    }

    function it_returns_same_request_id_everytime()
    {
        $id = $this->getRequestId();
        $this->getRequestId()->shouldReturn($id);
    }

    function it_returns_request_id_from_server_data()
    {
        $this->beConstructedWith(['UNIQUE_ID' => 'sqdfjhqsodukfhqsdui']);
        $this->getRequestId()->shouldReturn('sqdfjhqsodukfhqsdui');
    }
}
