<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;

class RequestIdResponseListener
{
    public const HEADER_KEY = 'X-Request-ID';

    /**
     * @var RequestIdProviderInterface
     */
    protected $requestIdProvider;

    public function __construct(RequestIdProviderInterface $requestIdProvider)
    {
        $this->requestIdProvider = $requestIdProvider;
    }

    /**
     * @param ResponseEvent|FilterResponseEvent $event
     */
    public function onKernelResponse($event): void
    {
        // Compatibility with Symfony < 5 and Symfony >=5
        if (!$event instanceof FilterResponseEvent && !$event instanceof ResponseEvent) {
            return;
        }

        $event->getResponse()->headers->set(self::HEADER_KEY, $this->requestIdProvider->getRequestId());
    }
}
