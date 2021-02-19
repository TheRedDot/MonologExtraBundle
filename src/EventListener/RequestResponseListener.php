<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use TheRedDot\MonologExtraBundle\Logger\Request\RequestLoggerInterface;
use TheRedDot\MonologExtraBundle\Logger\Response\ResponseLoggerInterface;

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

    /**
     * @param RequestEvent|GetResponseEvent $event
     */
    public function onRequest($event): void
    {
        // Compatibility with Symfony < 5 and Symfony >=5
        if (!$event instanceof GetResponseEvent && !$event instanceof RequestEvent) {
            return;
        }

        if (HttpKernel::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $this->requestLogger->logRequest($event->getRequest());
    }

    /**
     * @param ResponseEvent|FilterResponseEvent $event
     */
    public function onResponse($event): void
    {
        // Compatibility with Symfony < 5 and Symfony >=5
        if (!$event instanceof FilterResponseEvent && !$event instanceof ResponseEvent) {
            return;
        }

        $this->responseLogger->logResponse($event->getResponse(), $event->getRequest());
    }
}
