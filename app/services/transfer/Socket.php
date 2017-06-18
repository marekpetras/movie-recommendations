<?php

namespace app\services\transfer;

use app\services\transfer\interfaces\SocketInterface;
use app\services\transfer\exceptions\SocketException;
use app\services\transfer\interfaces\ResponseInterface;
use app\services\transfer\interfaces\RequestInterface;
use app\services\transfer\interfaces\ResponseDecoderInterface;

/**
 * Class Socket
 * Handles the socket open write read close cycle
 * Can open persistent and reuse open socket
 * Can also decode some types of transfer encoding
 */
class Socket implements SocketInterface
{
    private $_host;
    private $_port = 80;
    private $_timeout;
    private $_socket;
    private $_maxAttempts;
    private $_responseDecoder;

    /**
     * Constructor
     * @param int $timeout sets max timeout for socket opening
     * @param int $maxAttempts sets in how many attempts to write in case of failure, if fails, reopen socket and try again
     */
    public function __construct(int $timeout = 5, int $maxAttempts = 10)
    {
        $this->_timeout = $timeout;
        $this->_maxAttempts = $maxAttempts;
    }

    /**
     * Destructor
     * closes open connection
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * ResponseDecoder getter
     * @return ResponseDecoderInterface
     */
    public function getResponseDecoder(): ResponseDecoderInterface
    {
        return $this->_responseDecoder;
    }

    /**
     * ResponseDecoder setter
     * @param ResponseDecoderInterface @responseDecoder
     * @return SocketInterface
     */
    public function setResponseDecoder( ResponseDecoderInterface $responseDecoder ): SocketInterface
    {
        $this->_responseDecoder = $responseDecoder;
        return $this;
    }

    /**
     * Host setter
     * @param string $host open connection to here, for https:// use ssl://
     * @return SocketInterface
     */
    public function setHost( string $host ): SocketInterface
    {
        $this->_host = $host;
        return $this;
    }

    /**
     * Port setter
     * @param int $port on which port the transfer should run
     * @return SocketInterface
     */
    public function setPort( int $port ): SocketInterface
    {
        $this->_port = $port;
        return $this;
    }

    /**
     * Check whether a socket is currently open
     * @return bool true if it is open or false if its not
     * @todo check socket metadata
     */
    public function isOpen(): bool
    {
        return isset($this->_socket) && is_resource($this->_socket);
    }

    /**
     * open a socket and save it in object
     * @param bool $useExisting whether to use already open socket or open new every time
     * @param bool $persistent whether to use fsockopen or pfsockopen for persistency
     * @return SocketInterface
     * @throws SocketException if fails to open socket
     */
    public function open( bool $useExisting = true, bool $persistent = false ): SocketInterface
    {
        if ( is_resource($this->_socket) ) {

            if ( $useExisting ) {
                return $this->_socket;
            }

            $this->close();
        }

        $errno = 0;
        $errstr = null;
        $method = $persistent ? 'pfsockopen' : 'fsockopen';

        $this->_socket = @$method($this->_host, $this->_port, $errno, $errstr, $this->_timeout);

        if ( $this->_socket === false ) {
            throw new SocketException(sprintf('Failed to %s to %s:%d, (%d) %s', $method, $this->_host, $this->_port, $errno, $errstr));
        }

        return $this;
    }

    /**
     * Close open socket
     * @return SocketInterface
     * @throws SocketException on failure to close socket
     */
    public function close(): SocketInterface
    {
        if ( $this->isOpen() ) {
            if ( !fclose($this->_socket) ) {
                throw new SocketException('Failed to close socket');
            }
        }

        return $this;
    }

    /**
     * write request into the socket
     * @param RequestInterface $request desired request containing valid http request string
     * @return SocketInterface
     * @throws SocketException on failure to write after $maxAttempts attempts
     */
    public function write( RequestInterface $request ): SocketInterface
    {
        $attempts = 0;

        if ( !$this->isOpen() ) {
            $this->open();
        }

        do {
            $bytes = fwrite($this->_socket,(string) $request);
            if ( !$bytes ) {
                sleep(1);
                $this->open(false);
                $attempts++;
            }

        } while ( !$bytes && $attempts < $this->_maxAttempts);

        if ( !$bytes ) {
            throw new SocketException(sprintf('Failed to write to the stream in %d attempts', $attempts));
        }

        return $this;
    }

    /**
     * read response from socket
     * @return ResponseInterface
     * @throws SocketException on trying to read from unopened socket
     */
    public function read(): ResponseInterface
    {
        $response = '';

        if ( !$this->isOpen() ) {
            throw new SocketException('Cant read from closed socket.');
        }

        while(!feof($this->_socket)) {
            $response .= fgets($this->_socket, 4096);
        }

        return new Response($response, $this->getResponseDecoder());
    }
}