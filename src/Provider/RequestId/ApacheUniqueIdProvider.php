<?php

namespace Hexanet\Common\MonologExtraBundle\Provider\RequestId;

class ApacheUniqueIdProvider implements RequestIdProviderInterface
{
    /**
     * @var string
     */
    protected $requestId;

    /**
     * @param array|null $serverData
     */
    public function __construct(array $serverData = null)
    {
        $requestId = uniqid();

        if (!is_array($serverData)) {
            $serverData = &$_SERVER;
        }

        if (isset($serverData['UNIQUE_ID'])) {
            $requestId = $serverData['UNIQUE_ID'];
        }

        $this->requestId = $requestId;
    }

    /**
     * @return string
     */
    public function getRequestId() : string
    {
        return $this->requestId;
    }
}
