<?php

namespace TheRedDot\MonologExtraBundle\Provider\RequestId;

interface RequestIdProviderInterface
{
    public function getRequestId() : string;
}
