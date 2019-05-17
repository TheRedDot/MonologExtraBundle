<?php

namespace Hexanet\Common\MonologExtraBundle\Provider\User;

interface UserProviderInterface
{
    public function getUser() : string;
}