<?php

namespace TheRedDot\MonologExtraBundle\Provider\Session;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SymfonySessionIdProvider implements SessionIdProviderInterface
{
    public const SESSION_ID_UNKNOWN = 'unknown';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var bool
     */
    private $startSession;

    public function __construct(SessionInterface $session, bool $startSession = false)
    {
        $this->session = $session;
        $this->startSession = $startSession;
    }

    public function getSessionId(): string
    {
        try {
            if ($this->startSession && !$this->session->isStarted()) {
                $this->session->start();
            }

            if ($this->session->isStarted()) {
                return $this->session->getId();
            }
        } catch (\RuntimeException $e) {
        }

        return self::SESSION_ID_UNKNOWN;
    }
}
