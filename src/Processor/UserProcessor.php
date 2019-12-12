<?php

namespace TheRedDot\MonologExtraBundle\Processor;

use TheRedDot\MonologExtraBundle\Provider\User\UserProviderInterface;

/**
 * Add user informations to monolog record.
 */
class UserProcessor
{
    /**
     * @var UserProviderInterface
     */
    protected $userProvider;

    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @param array<mixed> $record
     *
     * @return array<mixed>
     */
    public function processRecord(array $record): array
    {
        $record['extra']['user'] = $this->userProvider->getUser();

        return $record;
    }
}
