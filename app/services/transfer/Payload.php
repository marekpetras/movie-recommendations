<?php

namespace app\services\transfer;

use app\services\transfer\interfaces\PayloadInterface;

/**
 * Class Payload
 * represents a payload (key value pairs) that can be inserted in a Body
 */
class Payload implements PayloadInterface
{
    private $_data = [];

    /**
     * Constructor
     * @param array $data payload data
     */
    public function __construct( array $data )
    {
        $this->_data = $data;
    }

    /**
     * stringify the data into a http query
     * @return string key value query data
     */
    public function __toString(): string
    {
        return http_build_query($this->_data);
    }
}