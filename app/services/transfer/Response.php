<?php

namespace app\services\transfer;

use app\services\transfer\interfaces\ResponseInterface;
use app\services\transfer\exceptions\ResponseException;
use app\services\transfer\interfaces\ResponseDecoderInterface;

/**
 * Class Response
 * Reads and parses response from a http request
 * @todo add more types of exceptions to differentiate between invalid request and status code != 200
 */
class Response implements ResponseInterface
{
    private $_response;
    private $_headers;
    private $_body;
    private $_statusCode;
    private $_statusMessage;
    private $_responseDecoder;

    /**
     * Constructor
     * @param string $response response to a http request
     * @param ResponseDecoderInterface $responseDecoder service for decoding requests
     * coded with some Transfer-Encoding read from the http header
     * @throws ResponseException on failure to retrieve HTTP status code from first line of response
     * @throws ResponseException on http status code != 200
     */
    public function __construct( string $response, ResponseDecoderInterface $responseDecoder )
    {
        $this->_response = $response;
        $this->_responseDecoder = $responseDecoder;

        [$this->_headers,$this->_body] = explode("\r\n\r\n",$this->_response);

        $this->_headers = explode("\r\n",$this->_headers);
        $status = array_shift($this->_headers);
        $this->_headers = $this->parseHeaders($this->_headers);

        $matches = [];

        if( !preg_match('/HTTP\/([0-9\.]){3}\ (?P<statusCode>[0-9]+)\ (?P<statusMessage>.*)/', $status, $matches) ) {
            throw new ResponseException(500, 'Failed to retrieve http header out of ' . $status, $response);
        }

        $this->_statusCode = (int)$matches['statusCode'];
        $this->_statusMessage = $matches['statusMessage'];

        if ( $this->_statusCode !== 200 ) {
            throw new ResponseException($this->_statusCode, $this->_statusMessage, $response);
        }
    }

    /**
     * ResponseDecoder getter
     * initiate correct decoder based on transfer encoding
     * @return ResponseDecoderInterface
     */
    private function getResponseDecoder(): ResponseDecoderInterface
    {
        return $this->_responseDecoder->getDecoder($this->getHeader('Transfer-Encoding'));
    }

    /**
     * parse http headers
     * @param array $raw headers - one line each header
     * @return array parsed headers
     */
    private function parseHeaders( array $raw ): array
    {
        $headers = [];
        foreach ( $raw as $head ) {
            [$name,$value] = explode(':',$head);
            $headers[$name] = trim($value);
        }
        return $headers;
    }

    /**
     * get specific header
     * @param string $name header name
     * @return string header value or null if not set
     */
    public function getHeader( string $name ): ?string
    {
        return $this->_headers[$name] ?? null;
    }

    /**
     * get all the headers from the response
     * @return array headers
     */
    public function getHeaders(): array
    {
        return $this->_headers;
    }

    /**
     * get decoded body
     * @return string body of the response
     */
    public function getBody(): string
    {
        return $this->getResponseDecoder()->decode($this->_body);
    }

    /**
     * get current status code
     * @return int http status code
     */
    public function getStatusCode(): int
    {
        return $this->_statusCode;
    }

    /**
     * get current status message
     * @return string http status message
     */
    public function getStatusMessage(): string
    {
        return $this->_statusMessage;
    }

    /**
     * return whole raw response
     * @return string response
     */
    public function __toString(): string
    {
        return $this->_response;
    }
}