<?php

namespace spec\Hexanet\Common\MonologExtraBundle\Provider\Uid;

use Hexanet\Common\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;
use Hexanet\Common\MonologExtraBundle\Provider\RequestId\UniqidProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UniqidProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UniqidProvider::class);
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
}
