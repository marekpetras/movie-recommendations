<?php

namespace app\services\transfer;

use app\services\transfer\interfaces\TransferInterface;
use app\services\transfer\interfaces\SocketInterface;
use app\services\transfer\interfaces\ResponseInterface;
use app\services\transfer\interfaces\RequestInterface;
use app\services\source\interfaces\SocketSourceInterface;

/**
 * Class Transfer
 *
 * Service that is supposed to handle the transfer from and to a socket via fsockopen
 * You can write and read separetly ensuring only necessary actions are taken
 */
class Transfer implements TransferInterface
{
    private $_socket;
    private $_source;

    /**
     * Constructor
     *
     * @param SocketInterface service
     * @param SocketSourceInterface service
     */
    public function __construct(SocketInterface $socket,SocketSourceInterface $source)
    {
        $this->setSocket($socket);
        $this->setSource($source);
    }

    /**
     * Socket service setter
     * @param SocketInterface $socket
     * @return Transferinterface
     */
    public function setSocket(SocketInterface $socket): TransferInterface
    {
        $this->_socket = $socket;
        return $this;
    }

    /**
     * Socket service getter
     * @return SocketInterface
     */
    public function getSocket(): SocketInterface
    {
        return $this->_socket;
    }

    /**
     * SocketSource service setter
     * @param SocketSourceInterface $source
     * @return TransferInterface
     */
    public function setSource(SocketSourceInterface $source): TransferInterface
    {
        $this->_source = $source;
        $this->_socket->setHost($source->getHost())
            ->setPort($source->getPort());
        return $this;
    }

    /**
     * SocketSource service getter
     * @return SocketSourceInterface
     */
    public function getSource(): SocketSourceInterface
    {
        return $this->_source;
    }

    /**
     * executes the transfer to and from socket and return response
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function getResponse(RequestInterface $request): ResponseInterface
    {
        $request->setPath($this->getSource()->getPath())
            ->setBody($this->getSource()->getBody())
            ->setHeaders($this->getSource()->getHeaders());

        $this->getSocket()->write($request);

        return $this->getSocket()->read();
    }
}