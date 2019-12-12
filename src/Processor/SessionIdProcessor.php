<?php

namespace TheRedDot\MonologExtraBundle\Processor;

use TheRedDot\MonologExtraBundle\Provider\Session\SessionIdProviderInterface;

/**
 * Add session id to monolog messages.
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

    /**
     * @param array<mixed> $record
     *
     * @return array<mixed>
     */
    public function processRecord(array $record): array
    {
        $record['extra']['session_id'] = $this->sessionIdProvider->getSessionId();

        return $record;
    }
}
