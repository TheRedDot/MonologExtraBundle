<?php

namespace TheRedDot\MonologExtraBundle\Provider\RequestId;

final class ServerRequestIdProvider implements RequestIdProviderInterface
{
    /**
     * @var string
     */
    private $requestId;

    public function __construct(string $serverField, array $serverData = null)
    {
        $requestId = uniqid();

        if (!is_array($serverData)) {
            $serverData = &$_SERVER;
        }

        if (isset($serverData[$serverField])) {
            $requestId = $serverData[$serverField];
        }

        $this->requestId = $requestId;
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
