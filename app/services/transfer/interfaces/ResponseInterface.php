<?php

namespace app\services\transfer\interfaces;

/**
 * Interface ResponseInterface
 */
interface ResponseInterface
{
    /**
     * Constructor
     * @param string $response response to a http request
     * @param ResponseDecoderInterface $responseDecoder service for decoding requests
     * coded with some Transfer-Encoding read from the http header
     * @throws ResponseException on failure to retrieve HTTP status code from first line of response
     * @throws ResponseException on http status code != 200
     */
    public function __construct( string $response, ResponseDecoderInterface $responseDecoder );

    /**
     * get specific header
     * @param string $name header name
     * @return string header value or null if not set
     */
    public function getHeader( string $name ): ?string;

    /**
     * get all the headers from the response
     * @return array headers
     */
    public function getHeaders(): array;

    /**
     * get decoded body
     * @return string body of the response
     */
    public function getBody(): string;

    /**
     * get current status code
     * @return int http status code
     */
    public function getStatusCode(): int;

    /**
     * get current status message
     * @return string http status message
     */
    public function getStatusMessage(): string;
}