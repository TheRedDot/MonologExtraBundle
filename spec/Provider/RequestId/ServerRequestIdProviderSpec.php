<?php

namespace spec\TheRedDot\MonologExtraBundle\Provider\RequestId;

use TheRedDot\MonologExtraBundle\Provider\RequestId\ServerRequestIdProvider;
use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;
use PhpSpec\ObjectBehavior;

class ServerRequestIdProviderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('UNIQUE_ID');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ServerRequestIdProvider::class);
    }

    public function it_implements_request_id_provider_interface()
    {
        $this->shouldImplement(RequestIdProviderInterface::class);
    }

    public function it_returns_request_id()
    {
        $this->getRequestId()->shouldBeString();
    }

    public function it_returns_same_request_id_everytime()
    {
        $id = $this->getRequestId();
        $this->getRequestId()->shouldReturn($id);
    }

    public function it_returns_request_id_from_server_data()
    {
        $this->beConstructedWith('UNIQUE_ID', ['UNIQUE_ID' => 'sqdfjhqsodukfhqsdui']);
        $this->getRequestId()->shouldReturn('sqdfjhqsodukfhqsdui');
    }
}
