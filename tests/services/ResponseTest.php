<?php

use PHPUnit\Framework\TestCase;

use app\services\transfer\Response;
use app\services\transfer\responsedecoders\ResponseDecoder;

/**
 * @covers app\services\transfer\Transfer
 */
class ResponseTest extends TestCase
{
    public function testCreate(): void
    {
        $responseDecoder = $this->createMock(ResponseDecoder::class);
        $responseDecoder->method('getDecoder')
            ->willReturn($responseDecoder);
        $responseDecoder->method('decode')
             ->will($this->returnCallback(function($arg){return $arg;}));
        $response = new Response($this->getHttpResponse(), $responseDecoder);

        $this->assertInstanceOf(
            Response::class,
            $response
            );

        $connectionHeader = $response->getHeader('Connection');
        $this->assertEquals(
            $connectionHeader,
            'close'
            );

        $json = $response->getBody();
        $this->assertInternalType(
            'array',
            json_decode($json,false)
            );
    }
    private function getHttpResponse(): string
    {
        $httpResponse = [];
        $httpResponse[] = "HTTP/1.1 200 OK";
        $httpResponse[] = "Date: Thu, 15 Jun 2017 05:39:13 GMT";
        $httpResponse[] = "Content-Type: text/plain; charset=utf-8";
        $httpResponse[] = "Connection: close";
        $httpResponse[] = "Cache-Control: public, max-age=1801";
        $httpResponse[] = "Expires: Thu, 15 Jun 2017 06:09:14 GMT";
        $httpResponse[] = "Server: cloudflare-nginx";
        $httpResponse[] = "";
        $httpResponse[] = "[
    {
        \"name\": \"Moonlight\"
    }
]";
        return implode("\r\n",$httpResponse);
    }
}