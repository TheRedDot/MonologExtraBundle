<?php

namespace TheRedDot\MonologExtraBundle\Provider\User;

interface UserProviderInterface
{
    public function getUser() : string;
}
