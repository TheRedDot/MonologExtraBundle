<?php

namespace TheRedDot\MonologExtraBundle\Provider\Session;

interface SessionIdProviderInterface
{
    public function getSessionId() : string;
}
