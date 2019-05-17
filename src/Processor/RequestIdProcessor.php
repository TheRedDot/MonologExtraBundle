<?php

namespace Hexanet\Common\MonologExtraBundle\Processor;

use Hexanet\Common\MonologExtraBundle\Provider\RequestId\RequestIdProviderInterface;

class RequestIdProcessor
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
     * Process a record
     *
     * @param array $record
     *
     * @return array
     */
    public function processRecord(array $record) : array
    {
        $record['extra']['request_id'] = $this->requestIdProvider->getRequestId();

        return $record;
    }
}
