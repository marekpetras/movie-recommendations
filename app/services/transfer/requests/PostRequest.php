<?php

namespace app\services\transfer\requests;

use app\services\transfer\Request;
use app\services\transfer\interfaces\RequestInterface;

/**
 * Class PostRequest
 * represent POST http request
 */
class PostRequest extends Request implements RequestInterface
{
    /**
     * type getter
     * @return string http request type
     */
    protected function getType(): string
    {
        return 'POST';
    }
}