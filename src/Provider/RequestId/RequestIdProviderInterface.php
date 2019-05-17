<?php

namespace Hexanet\Common\MonologExtraBundle\Provider\RequestId;

interface RequestIdProviderInterface
{
    /**
     * @return string
     */
    public function getRequestId() : string;
}