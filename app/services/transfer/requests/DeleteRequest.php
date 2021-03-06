<?php

namespace app\services\transfer\requests;

use app\services\transfer\Request;
use app\services\transfer\interfaces\RequestInterface;

/**
 * Class DeleteRequest
 * represent Delete http request
 */
class DeleteRequest extends Request implements RequestInterface
{
    /**
     * type getter
     * @return string http request type
     */
    protected function getType(): string
    {
        return 'DELETE';
    }
}