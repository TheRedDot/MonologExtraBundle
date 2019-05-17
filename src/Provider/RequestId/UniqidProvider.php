<?php

namespace Hexanet\Common\MonologExtraBundle\Provider\RequestId;

class UniqidProvider implements RequestIdProviderInterface
{
    /**
     * @var string
     */
    protected $requestId;

    public function __construct()
    {
        $this->requestId = uniqid();
    }

    /**
     * @return string
     */
    public function getRequestId() : string
    {
        return $this->requestId;
    }
}
