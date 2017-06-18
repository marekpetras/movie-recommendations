<?php

use PHPUnit\Framework\TestCase;

use app\services\source\Pastebin;

/**
 * @covers app\services\source\Pastebin
 */
class PastebinTest extends TestCase
{
    public function testSource(): void
    {
        $source  = new Pastebin();
        $socket = fsockopen($source->getHost(),$source->getPort());
        $this->assertInternalType(
            'resource',
            $socket
        );
    }
}