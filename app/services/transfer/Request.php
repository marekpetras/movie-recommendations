<?php

namespace app\services\transfer;

use app\services\transfer\interfaces\RequestInterface;
use app\services\transfer\interfaces\BodyInterface;

/**
 * Class Request
 * represents an http request
 * specify http request type by calling one of the child classes (PUT,GET,POST etc)
 */
abstract class Request implements RequestInterface
{
    protected $_body;
    protected $_path;
    protected $_headers = [];

    /**
     * Constructor
     * @param ?string $path the server path of the request
     * @param ?BodyInterface $body the body of the request
     * @param array $headers optional http headers to include
     */
    public function __construct( ?string $path = null, ?BodyInterface $body = null, array $headers = [] )
    {
        $this->_body = $body;
        $this->_path = $path;
        $this->_headers = $headers;
    }

    /**
     * Body setter
     * @param ?BodyInterface $body body of the request
     * @return RequestInterface
     */
    public function setBody(?BodyInterface $body): RequestInterface
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * Headers setter
     * @param array $headers
     * @return RequestInterface
     */
    public function setHeaders(array $headers): RequestInterface
    {
        $this->_headers = $headers;
        return $this;
    }

    /**
     * Path setter
     * @param string $path
     * @return RequestInterface
     */
    public function setPath(string $path): RequestInterface
    {
        $this->_path = $path;
        return $this;
    }

    /**
     * type getter
     * @return string http request type
     */
    abstract protected function getType(): string;

    /**
     * string representation of the request to be written to a web server
     * @return string http request
     */
    public function __toString(): string
    {
        $request = [];
        $request[] = $this->getType() . ' ' . $this->_path . ' HTTP/1.1';
        foreach ( $this->_headers as $key => $value ) {
            $request[] = ucfirst($key).': ' . $value;
        }
        $request[] = 'Content-length: ' . strlen((string) $this->_body);
        $request[] = 'Connection: close';
        $request[] = '';
        $request[] = (string) $this->_body;

        return implode("\r\n",$request);
    }
}