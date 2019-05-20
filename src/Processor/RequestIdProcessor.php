<?php

namespace TheRedDot\MonologExtraBundle\Processor;

use TheRedDot\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;

class RequestIdProcessor
{
    /**
     * @var RequestIdProviderInterface
     */
    protected $requestIdProvider;

    public function __construct(RequestIdProviderInterface $requestIdProvider)
    {
        $this->requestIdProvider = $requestIdProvider;
    }

    public function processRecord(array $record): array
    {
        $record['extra']['request_id'] = $this->requestIdProvider->getRequestId();

        return $record;
    }
}
