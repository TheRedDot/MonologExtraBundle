<?php

namespace TheRedDot\MonologExtraBundle\Logger\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ResponseLoggerInterface
{
    public function logResponse(Response $response, Request $request) : void;

}
