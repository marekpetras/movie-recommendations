<?php

namespace app\services\transfer\interfaces;

use app\services\transfer\interfaces\BodyInterface;

/**
 * Interface RequestInterface
 */
interface RequestInterface
{
    /**
     * Body setter
     * @param ?BodyInterface $body body of the request
     * @return RequestInterface
     */
    public function setBody(?BodyInterface $body): RequestInterface;

    /**
     * Headers setter
     * @param array $headers
     * @return RequestInterface
     */
    public function setHeaders(array $headers): RequestInterface;

    /**
     * Path setter
     * @param string $path
     * @return RequestInterface
     */
    public function setPath(string $path): RequestInterface;

    /**
     * string representation of the request to be written to a web server
     * @return string http request
     */
    public function __toString(): string;
}