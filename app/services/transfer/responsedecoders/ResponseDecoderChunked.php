<?php

namespace app\services\transfer\responsedecoders;

use app\services\transfer\interfaces\ResponseDecoderInterface;

/**
 * Class RespondeDecoderChunked
 * decodes Transfer-Encoding: chunked
 */
class ResponseDecoderChunked extends ResponseDecoder implements ResponseDecoderInterface
{
    /**
     * decodes the request
     * @param string $str
     * @return string decoded
     */
    public function decode( string $str ): string
    {
        for ($res = ''; !empty($str); $str = trim($str)) {
            $pos = strpos($str, "\r\n");
            $len = hexdec(substr($str, 0, $pos));
            $res.= substr($str, $pos + 2, $len);
            $str = substr($str, $pos + 2 + $len);
        }
        return $res;
    }
}
