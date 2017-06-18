<?php

use PHPUnit\Framework\TestCase;

use app\services\transfer\responsedecoders\ResponseDecoder;
use app\services\transfer\responsedecoders\ResponseDecoderChunked;
use app\services\transfer\responsedecoders\ResponseDecoderDefault;

/**
 * @covers app\services\transfer\responsedecoders\ResponseDecoder
 * @covers app\services\transfer\responsedecoders\ResponseDecoderChunked
 * @covers app\services\transfer\responsedecoders\ResponseDecoderDefault
 */
class ResponseDecoderTest extends TestCase
{
    public function testCreate(): void
    {
        $responseDecoder = new ResponseDecoder();
        $this->assertInstanceOf(
            ResponseDecoderDefault::class,
            $responseDecoder->getDecoder(null)
        );

    }
    public function testDecodeChunked(): void
    {
        $responseDecoder = new ResponseDecoder();
        $decoder = $responseDecoder->getDecoder('chunked');
        $this->assertInstanceOf(
            ResponseDecoderChunked::class,
            $decoder
        );

        $decoded = $decoder->decode($this->getHttpResponse());

        $this->assertStringStartsWith(
            '[',
            $decoded
        );
    }
    private function getHttpResponse(): string
    {
        return implode("\r\n",explode(PHP_EOL,'3bc
[
    {
        "name": "Moonlight",
        "rating": 98,
        "genres": [
            "Drama"
        ],
        "showings": [
            "18:30:00+11:00",
            "20:30:00+11:00"
        ]
    },
    {
        "name": "Zootopia",
        "rating": 92,
        "genres": [
            "Action & Adventure",
            "Animation",
            "Comedy"
        ],
        "showings": [
            "19:00:00+11:00",
            "21:00:00+11:00"
        ]
    },
    {
        "name": "The Martian",
        "rating": 92,
        "genres": [
            "Science Fiction & Fantasy"
        ],
        "showings": [
            "17:30:00+11:00",
            "19:30:00+11:00"
        ]
    },
    {
        "name": "Shaun The Sheep",
        "rating": 80,
        "genres": [
            "Animation",
            "Comedy"
        ],
        "showings": [
            "19:00:00+11:00"
        ]
    }
]
0

'));
    }
}