<?php

namespace spec\TheRedDot\MonologExtraBundle\Provider\Uid;

use TheRedDot\MonologExtraBundle\Provider\RequestId\ApacheUniqueIdProvider;
use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;
use PhpSpec\ObjectBehavior;

class ApacheUniqueIdProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ApacheUniqueIdProvider::class);
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
        $this->beConstructedWith(['UNIQUE_ID' => 'sqdfjhqsodukfhqsdui']);
        $this->getRequestId()->shouldReturn('sqdfjhqsodukfhqsdui');
    }
}
