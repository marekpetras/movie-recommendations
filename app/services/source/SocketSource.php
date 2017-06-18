<?php

namespace app\services\source;

use app\services\source\interfaces\SocketSourceInterface;
use app\services\transfer\interfaces\BodyInterface;

/**
 * Class SocketSource
 * represents source for socket transfer to get some data from web endpoint/api/etc
 */
class SocketSource implements SocketSourceInterface
{
    /* http request params */
    protected $_path;
    protected $_port;
    protected $_host;
    protected $_headers = [];
    protected $_type = 'GET';
    protected $_body = null;

    /**
     * path getter
     * @return string path
     */
    public function getPath(): string
    {
        return $this->_path;
    }

    /**
     * port getter
     * @return int port
     */
    public function getPort(): int
    {
        return $this->_port;
    }

    /**
     * host getter
     * @return string host
     */
    public function getHost(): string
    {
        return $this->_host;
    }

    /**
     * headers getter
     * @return array headers
     */
    public function getHeaders(): array
    {
        return $this->_headers;
    }

    /**
     * type getter
     * @return string type
     */
    public function getType(): string
    {
        return $this->_type;
    }

    /**
     * body setter
     * @param BodyInterface $body to be sent with the request to host and port
     * @return SocketSourceInterface
     */
    public function setBody(BodyInterface $body): SocketSourceInterface
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * body getter
     * @return ?BodyInterface
     */
    public function getBody(): ?BodyInterface
    {
        return $this->_body;
    }
}