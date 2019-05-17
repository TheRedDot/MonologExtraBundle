<?php

namespace Hexanet\Common\MonologExtraBundle\Provider\RequestId;

final class UniqidProvider implements RequestIdProviderInterface
{
    /**
     * @var string
     */
    private $requestId;

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
