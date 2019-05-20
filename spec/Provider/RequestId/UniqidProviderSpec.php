<?php

namespace spec\TheRedDot\MonologExtraBundle\Provider\RequestId;

use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;
use TheRedDot\MonologExtraBundle\Provider\RequestId\UniqidProvider;
use PhpSpec\ObjectBehavior;

class UniqidProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UniqidProvider::class);
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
}
