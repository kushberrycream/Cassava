<?php

namespace _JchOptimizeVendor\GuzzleHttp;

use _JchOptimizeVendor\GuzzleHttp\Promise\PromiseInterface;
use _JchOptimizeVendor\Psr\Http\Message\RequestInterface;

/**
 * Prepares requests that contain a body, adding the Content-Length,
 * Content-Type, and Expect headers.
 *
 * @final
 */
class PrepareBodyMiddleware
{
    /**
     * @var callable(RequestInterface, array): PromiseInterface
     */
    private $nextHandler;

    /**
     * @param callable(RequestInterface, array): PromiseInterface $nextHandler next handler to invoke
     */
    public function __construct(callable $nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }

    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $fn = $this->nextHandler;
        // Don't do anything if the request has no body.
        if (0 === $request->getBody()->getSize()) {
            return $fn($request, $options);
        }
        $modify = [];
        // Add a default content-type if possible.
        if (!$request->hasHeader('Content-Type')) {
            if ($uri = $request->getBody()->getMetadata('uri')) {
                if (\is_string($uri) && ($type = Psr7\MimeType::fromFilename($uri))) {
                    $modify['set_headers']['Content-Type'] = $type;
                }
            }
        }
        // Add a default content-length or transfer-encoding header.
        if (!$request->hasHeader('Content-Length') && !$request->hasHeader('Transfer-Encoding')) {
            $size = $request->getBody()->getSize();
            if (null !== $size) {
                $modify['set_headers']['Content-Length'] = $size;
            } else {
                $modify['set_headers']['Transfer-Encoding'] = 'chunked';
            }
        }
        // Add the expect header if needed.
        $this->addExpectHeader($request, $options, $modify);

        return $fn(Psr7\Utils::modifyRequest($request, $modify), $options);
    }

    /**
     * Add expect header.
     */
    private function addExpectHeader(RequestInterface $request, array $options, array &$modify): void
    {
        // Determine if the Expect header should be used
        if ($request->hasHeader('Expect')) {
            return;
        }
        $expect = $options['expect'] ?? null;
        // Return if disabled or if you're not using HTTP/1.1 or HTTP/2.0
        if (\false === $expect || $request->getProtocolVersion() < 1.1) {
            return;
        }
        // The expect header is unconditionally enabled
        if (\true === $expect) {
            $modify['set_headers']['Expect'] = '100-Continue';

            return;
        }
        // By default, send the expect header when the payload is > 1mb
        if (null === $expect) {
            $expect = 1048576;
        }
        // Always add if the body cannot be rewound, the size cannot be
        // determined, or the size is greater than the cutoff threshold
        $body = $request->getBody();
        $size = $body->getSize();
        if (null === $size || $size >= (int) $expect || !$body->isSeekable()) {
            $modify['set_headers']['Expect'] = '100-Continue';
        }
    }
}
