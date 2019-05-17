<?php

namespace Hexanet\Common\MonologExtraBundle\Processor;

use Hexanet\Common\MonologExtraBundle\Provider\User\UserProviderInterface;

/**
 * Add user informations to monolog record
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

    public function processRecord(array $record) : array
    {
        $record['extra']['user'] = $this->userProvider->getUser();

        return $record;
    }
}