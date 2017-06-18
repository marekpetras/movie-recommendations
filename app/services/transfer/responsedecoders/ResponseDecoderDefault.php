<?php

namespace app\services\transfer\responsedecoders;

use app\services\transfer\interfaces\ResponseDecoderInterface;

/**
 * Class ResponseDecoderDefault
 * when no encoding
 */
class ResponseDecoderDefault extends ResponseDecoder implements ResponseDecoderInterface
{
    /**
     * decode body
     * @param string $str
     * @return string decoded
     */
    public function decode( string $str ): string
    {
        return $str;
    }
}
