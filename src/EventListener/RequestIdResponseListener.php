<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
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

    public function onKernelResponse(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set('X-Request-ID', $this->requestIdProvider->getRequestId());
    }
}
