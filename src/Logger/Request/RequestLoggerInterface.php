<?php

namespace TheRedDot\MonologExtraBundle\Logger\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestLoggerInterface
{
    public function logRequest(Request $request): void;
}
