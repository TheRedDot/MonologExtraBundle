<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;

class RequestIdResponseListener
{
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

        $event->getResponse()->headers->set('X-Request-ID', $this->requestIdProvider->getRequestId());
    }
}
