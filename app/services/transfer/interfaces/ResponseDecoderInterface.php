<?php

namespace app\services\transfer\interfaces;

/**
 * Interface ResponseDecoderInterface
 */
interface ResponseDecoderInterface
{
    /**
     * decodes the response
     * implement in child
     * @param string $body
     * @return string decoded body
     */
    public function decode( string $body ): string;

    /**
     * decoder factory
     * @param ?string $type if null use self::DEFAULT_TYPE
     * @return ResponseDecoderInterface
     * @throws ResponseDecoderException if unsupported decoder required
     */
    public function getDecoder( ?string $type ): ResponseDecoderInterface;
}