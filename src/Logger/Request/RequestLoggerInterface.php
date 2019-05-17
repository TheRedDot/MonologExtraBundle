<?php

namespace Hexanet\Common\MonologExtraBundle\Logger\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestLoggerInterface
{
    public function logRequest(Request $request) : void;

}