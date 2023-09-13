<?php

namespace _JchOptimizeVendor\GuzzleHttp;

use _JchOptimizeVendor\Psr\Http\Message\RequestInterface;
use _JchOptimizeVendor\Psr\Http\Message\ResponseInterface;

interface MessageFormatterInterface
{
    /**
     * Returns a formatted message string.
     *
     * @param RequestInterface       $request  Request that was sent
     * @param null|ResponseInterface $response Response that was received
     * @param null|\Throwable        $error    Exception that was received
     */
    public function format(RequestInterface $request, ?ResponseInterface $response = null, ?\Throwable $error = null): string;
}
