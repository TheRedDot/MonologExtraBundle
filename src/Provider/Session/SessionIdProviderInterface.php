<?php

namespace Hexanet\Common\MonologExtraBundle\Provider\Session;

interface SessionIdProviderInterface
{
    public function getSessionId() : string;
}