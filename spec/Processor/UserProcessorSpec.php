<?php

namespace spec\TheRedDot\MonologExtraBundle\Processor;

use PhpSpec\ObjectBehavior;
use TheRedDot\MonologExtraBundle\Processor\UserProcessor;
use TheRedDot\MonologExtraBundle\Provider\User\UserProviderInterface;

class UserProcessorSpec extends ObjectBehavior
{
    public function let(UserProviderInterface $userProvider)
    {
        $this->beConstructedWith($userProvider);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserProcessor::class);
    }

    public function it_adds_user_to_record(UserProviderInterface $userProvider)
    {
        $userProvider
            ->getUser()
            ->willReturn('boris');

        $this->processRecord(['message' => 'test log'])->shouldReturn([
            'message' => 'test log',
            'extra' => [
                'user' => 'boris',
            ],
        ]);
    }
}
