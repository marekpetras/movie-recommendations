<?php

use PHPUnit\Framework\TestCase;

use app\services\transfer\Transfer;

use app\services\source\SocketSource;
use app\services\transfer\Socket;

/**
 * @covers app\services\transfer\Transfer
 */
class TransferTest extends TestCase
{
    public function testCreate(): void
    {
        $socket = $this->createMock(Socket::class);
        $source = $this->createMock(SocketSource::class);
        $source->method('getHost')
             ->willReturn(WEBHOST);
        $source->method('getPort')
             ->willReturn(WEBPORT);

        $transfer = new Transfer($socket,$source);
        $this->assertInstanceOf(
            Transfer::class,
            $transfer
        );
        $this->assertInstanceOf(
            Transfer::class,
            $transfer
        );
        $this->assertInstanceOf(
            Transfer::class,
            $transfer
        );
    }
}