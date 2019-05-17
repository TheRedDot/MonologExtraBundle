<?php

namespace Hexanet\Common\MonologExtraBundle\Processor;

use Hexanet\Common\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;

class RequestIdProcessor
{
    /**
     * @var RequestIdProviderInterface
     */
    protected $requestIdProvider;

    public function __construct(RequestIdProviderInterface $uidProvider)
    {
        $this->requestIdProvider = $uidProvider;
    }

    public function processRecord(array $record) : array
    {
        $record['extra']['request_id'] = $this->requestIdProvider->getRequestId();

        return $record;
    }
}
