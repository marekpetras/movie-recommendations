<?php

namespace app\services\transfer\responsedecoders;

use app\services\transfer\interfaces\ResponseDecoderInterface;

/**
 * Class ResponseDecoder
 * decodes http response based on transfer encoding type
 */
class ResponseDecoder implements ResponseDecoderInterface
{
    private const DEFAULT_TYPE = 'default';

    /**
     * decodes the response
     * implement in child
     * @param string $body
     * @return string decoded body
     */
    public function decode( string $body ): string
    {
        throw new ResponseDecoderException('Use child instead.');
    }

    /**
     * decoder factory
     * @param ?string $type if null use self::DEFAULT_TYPE
     * @return ResponseDecoderInterface
     * @throws ResponseDecoderException if unsupported decoder required
     */
    public function getDecoder( ?string $type ): ResponseDecoderInterface
    {
        if ( $type === null ) {
            $type = self::DEFAULT_TYPE;
        }

        $class = self::class.ucfirst($type);
        if ( !class_exists($class) ) {
            throw new ResponseDecoderException(sprintf('"%s": Invalid decoder', $class));
        }
        return new $class;
    }
}
