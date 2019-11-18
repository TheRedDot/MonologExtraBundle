<?php

namespace spec\TheRedDot\MonologExtraBundle\Provider\Session;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use TheRedDot\MonologExtraBundle\Provider\Session\SessionIdProviderInterface;
use TheRedDot\MonologExtraBundle\Provider\Session\SymfonySessionIdProvider;

class SymfonySessionIdProviderSpec extends ObjectBehavior
{
    public function let(SessionInterface $session)
    {
        $this->beConstructedWith($session, true);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SymfonySessionIdProvider::class);
    }

    public function it_implements_session_id_provider_interface()
    {
        $this->shouldImplement(SessionIdProviderInterface::class);
    }

    public function it_starts_session(SessionInterface $session)
    {
        $session->isStarted()->willReturn(false);

        $session
            ->start()
            ->shouldBeCalled();

        $this->getSessionId()->shouldBeString();
    }

    public function it_returns_session_id(SessionInterface $session)
    {
        $session->isStarted()->willReturn(true);

        $session
            ->getId()
            ->shouldBeCalled()
            ->willReturn('dfsdfgdg4sdfg4s5df4');

        $this->getSessionId()->shouldBeString();
    }

    public function it_returns_specific_id_if_exception(SessionInterface $session)
    {
        $session
            ->start()
            ->willThrow(\RuntimeException::class);

        $this->getSessionId()->shouldReturn(SymfonySessionIdProvider::SESSION_ID_UNKNOWN);
    }
}
