<?php

namespace TheRedDot\MonologExtraBundle\Logger\Response;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponseLogger implements ResponseLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logResponse(Response $response, Request $request) : void
    {
        $msg = sprintf(
            'Response %s for "%s %s"',
            $response->getStatusCode(),
            $request->getMethod(),
            $request->getRequestUri()
        );

        $this->logger->info($msg, $this->createContext($response, $request));
    }

    public function getMemory() : int
    {
        $memory = memory_get_peak_usage(true);
        $memory = $memory > 1024 ? (int) ($memory / 1024) : 0;

        return $memory;
    }

    public function getTime(Request $request) : ?float
    {
        if (!$request->server) {
            return null;
        }

        $startTime = $request->server->get(
            'REQUEST_TIME_FLOAT',
            $request->server->get('REQUEST_TIME')
        );
        $time = microtime(true) - $startTime;
        $time = round($time * 1000);

        return (float) $time;
    }

    protected function createContext(Response $response, Request $request) : array
    {
        $context =  array(
            'response_status_code' => $response->getStatusCode(),
            'response_charset' => $response->getCharset(),
            'response_date' => $response->getDate(),
            'response_etag' => $response->getEtag(),
            'response_expires' => $response->getExpires(),
            'response_last_modified' => $response->getLastModified(),
            'response_max_age' => $response->getMaxAge(),
            'response_protocol_version' => $response->getProtocolVersion(),
            'response_ttl' => $response->getTtl(),
            'response_vary' => $response->getVary(),
            'request_method' => $request->getMethod(),
            'request_uri' => $request->getRequestUri(),
            'request_route' => $request->attributes->get('_route'),
            'response_time' => $this->getTime($request),
            'response_memory' => $this->getMemory()
        );

        return $context;
    }

}
