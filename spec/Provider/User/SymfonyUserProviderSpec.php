<?php

namespace spec\TheRedDot\MonologExtraBundle\Provider\User;

use TheRedDot\MonologExtraBundle\Provider\User\SymfonyUserProvider;
use TheRedDot\MonologExtraBundle\Provider\User\UserProviderInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SymfonyUserProviderSpec extends ObjectBehavior
{
    public function let(TokenStorageInterface $tokenStorage)
    {
        $this->beConstructedWith($tokenStorage);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SymfonyUserProvider::class);
    }

    public function it_implements_user_provider_interface()
    {
        $this->shouldImplement(UserProviderInterface::class);
    }

    public function it_returns_user()
    {
        $this->getUser()->shouldBeString();
    }
}
