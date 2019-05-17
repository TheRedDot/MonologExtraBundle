<?php

namespace Hexanet\Common\MonologExtraBundle\EventListener;

use Hexanet\Common\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class RequestIdResponseListener
{
    /**
     * @var RequestIdProviderInterface
     */
    protected $requestIdProvider;

    /**
     * @param RequestIdProviderInterface $uidProvider
     */
    public function __construct(RequestIdProviderInterface $uidProvider)
    {
        $this->requestIdProvider = $uidProvider;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event) : void
    {
        $event->getResponse()->headers->set('X-Request-ID', $this->requestIdProvider->getRequestId());
    }

}