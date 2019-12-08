<?php

namespace TheRedDot\MonologExtraBundle\Provider\RequestId;

final class ServerRequestIdProvider implements RequestIdProviderInterface
{
    /**
     * @var string
     */
    private $requestId;

    /**
     * @param string            $serverField
     * @param array<mixed>|null $serverData
     */
    public function __construct(string $serverField, array $serverData = null)
    {
        if (!is_array($serverData)) {
            $serverData = &$_SERVER;
        }

        $requestId = null;
        if (isset($serverData[$serverField])) {
            $requestId = $serverData[$serverField];
        }

        $this->requestId = $requestId ?? uniqid();
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
