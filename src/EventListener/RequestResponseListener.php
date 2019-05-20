<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

use TheRedDot\MonologExtraBundle\Logger\Request\RequestLoggerInterface;
use TheRedDot\MonologExtraBundle\Logger\Response\ResponseLoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class RequestResponseListener
{
    /**
     * @var RequestLoggerInterface
     */
    protected $requestLogger;

    /**
     * @var ResponseLoggerInterface
     */
    protected $responseLogger;

    public function __construct(RequestLoggerInterface $requestLogger, ResponseLoggerInterface $responseLogger)
    {
        $this->requestLogger = $requestLogger;
        $this->responseLogger = $responseLogger;
    }

    public function onRequest(GetResponseEvent $event) : void
    {
        if (HttpKernel::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $this->requestLogger->logRequest($event->getRequest());
    }

    public function onResponse(FilterResponseEvent $event) : void
    {
        $this->responseLogger->logResponse($event->getResponse(), $event->getRequest());
    }

}
