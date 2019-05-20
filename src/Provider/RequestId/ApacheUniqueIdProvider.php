<?php

namespace TheRedDot\MonologExtraBundle\Provider\RequestId;

final class ApacheUniqueIdProvider implements RequestIdProviderInterface
{
    /**
     * @var string
     */
    private $requestId;

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

    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
