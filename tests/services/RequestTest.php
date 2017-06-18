<?php

use PHPUnit\Framework\TestCase;

use app\services\transfer\requests\GetRequest;

/**
 * @covers app\services\transfer\Request
 * @covers app\services\transfer\requests\GetRequest
 * @covers app\services\transfer\requests\PutRequest
 * @covers app\services\transfer\requests\PostRequest
 * @covers app\services\transfer\requests\DeleteRequest
 */
class RequestTest extends TestCase
{
    public function testCreate(): void
    {
        $request = new GetRequest();
        $this->assertStringStartsWith(
            'GET',
            (string) $request
        );
    }
}