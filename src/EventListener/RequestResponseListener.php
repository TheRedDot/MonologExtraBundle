<?php

namespace TheRedDot\MonologExtraBundle\EventListener;

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

    public function onRequest(RequestEvent $event): void
    {
        if (HttpKernel::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $this->requestLogger->logRequest($event->getRequest());
    }

    public function onResponse(ResponseEvent $event): void
    {
        $this->responseLogger->logResponse($event->getResponse(), $event->getRequest());
    }
}
