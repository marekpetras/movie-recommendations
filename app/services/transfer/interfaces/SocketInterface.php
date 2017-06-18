<?php

namespace app\services\transfer\interfaces;

/**
 * Interface SocketInterface
 */
interface SocketInterface
{
    /**
     * ResponseDecoder getter
     * @return ResponseDecoderInterface
     */
    public function getResponseDecoder(): ResponseDecoderInterface;

    /**
     * ResponseDecoder setter
     * @param ResponseDecoderInterface @responseDecoder
     * @return SocketInterface
     */
    public function setResponseDecoder( ResponseDecoderInterface $responseDecoder ): SocketInterface;

    /**
     * Host setter
     * @param string $host open connection to here, for https:// use ssl://
     * @return SocketInterface
     */
    public function setHost( string $host ): SocketInterface;

    /**
     * Port setter
     * @param int $port on which port the transfer should run
     * @return SocketInterface
     */
    public function setPort( int $port ): SocketInterface;

    /**
     * Check whether a socket is currently open
     * @return bool true if it is open or false if its not
     * @todo check socket metadata
     */
    public function isOpen(): bool;

    /**
     * write request into the socket
     * @param RequestInterface $request desired request containing valid http request string
     * @return SocketInterface
     * @throws SocketException on failure to write after $maxAttempts attempts
     */
    public function write( RequestInterface $request ): SocketInterface;

    /**
     * read response from socket
     * @return ResponseInterface
     * @throws SocketException on trying to read from unopened socket
     */
    public function read(): ResponseInterface;

    /**
     * Close open socket
     * @return SocketInterface
     * @throws SocketException on failure to close socket
     */
    public function close(): SocketInterface;
}