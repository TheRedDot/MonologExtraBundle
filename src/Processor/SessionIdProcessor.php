<?php

namespace Hexanet\Common\MonologExtraBundle\Processor;

use Hexanet\Common\MonologExtraBundle\Provider\Session\SessionIdProviderInterface;

/**
 * Add session id to monolog messages
 */
class SessionIdProcessor
{
    /**
     * @var SessionIdProviderInterface
     */
    protected $sessionIdProvider;

    public function __construct(SessionIdProviderInterface $sessionIdProvider)
    {
        $this->sessionIdProvider = $sessionIdProvider;
    }

    public function processRecord(array $record) : array
    {
        $record['extra']['session_id'] = $this->sessionIdProvider->getSessionId();

        return $record;
    }
}