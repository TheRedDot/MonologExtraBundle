<?php

namespace Hexanet\Common\MonologExtraBundle\Provider\RequestId;

interface RequestIdProviderInterface
{
    public function getRequestId() : string;
}
