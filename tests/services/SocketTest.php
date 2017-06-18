<?php

use PHPUnit\Framework\TestCase;

use app\services\transfer\Socket;
use app\services\transfer\exceptions\SocketException;
use app\services\source\SocketSource;

/**
 * @covers app\services\transfer\Socket
 */
class SocketTest extends TestCase
{
    public function testValidSocket(): void
    {
        // Create a stub for the SomeClass class.
        $source = $this->createMock(SocketSource::class);

        // Configure the stub.
        $source->method('getHost')
             ->willReturn(WEBHOST);
        $source->method('getPort')
             ->willReturn(WEBPORT);

        $socket = new Socket();
        $socket->setHost($source->getHost());
        $socket->setPort($source->getPort());
        $socket->open();
        $this->assertInstanceOf(
            Socket::class,
            $socket
        );
    }

    public function testInvalidSocket(): void
    {
        $socket = new Socket();
        $socket->setHost('somehost');
        $this->expectException(SocketException::class);
        $socket->open();
    }
}