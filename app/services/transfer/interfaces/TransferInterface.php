<?php

namespace app\services\transfer\interfaces;

use app\services\source\interfaces\SocketSourceInterface;

/**
 * Interface TransferInterface
 */
interface TransferInterface
{
    /**
     * Constructor
     *
     * @param SocketInterface service
     * @param SocketSourceInterface service
     */
    public function __construct(SocketInterface $socket,SocketSourceInterface $source);

    /**
     * Socket service setter
     * @param SocketInterface $socket
     * @return Transferinterface
     */
    public function setSocket(SocketInterface $socket): TransferInterface;

    /**
     * Socket service getter
     * @return SocketInterface
     */
    public function getSocket(): SocketInterface;

    /**
     * SocketSource service setter
     * @param SocketSourceInterface $source
     * @return TransferInterface
     */
    public function setSource(SocketSourceInterface $source): TransferInterface;

    /**
     * SocketSource service getter
     * @return SocketSourceInterface
     */
    public function getSource(): SocketSourceInterface;

    /**
     * executes the transfer to and from socket and return response
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function getResponse(RequestInterface $request): ResponseInterface;
}