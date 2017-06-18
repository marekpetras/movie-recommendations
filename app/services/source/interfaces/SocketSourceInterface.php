<?php

namespace app\services\source\interfaces;

use app\services\transfer\interfaces\BodyInterface;

interface SocketSourceInterface
{
    /**
     * path getter
     * @return string path
     */
    public function getPath(): string;

    /**
     * port getter
     * @return int port
     */
    public function getPort(): int;

    /**
     * host getter
     * @return string host
     */
    public function getHost(): string;

    /**
     * headers getter
     * @return array headers
     */
    public function getHeaders(): array;

    /**
     * type getter
     * @return string type
     */
    public function getType(): string;

    /**
     * body setter
     * @param BodyInterface $body to be sent with the request to host and port
     * @return SocketSourceInterface
     */
    public function setBody(BodyInterface $body): SocketSourceInterface;

    /**
     * body getter
     * @return ?BodyInterface
     */
    public function getBody(): ?BodyInterface;
}