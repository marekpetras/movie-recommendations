<?php

namespace app\services\transfer\exceptions;

/**
 * Class ResponseException
 */
class ResponseException extends TransferException
{
    private $_response;

    /**
     * Constructor
     * @param int $errorNo
     * @param string $errorStr
     * @param string $response
     */
    public function __construct(int $errorNo, string $errorStr, string $response = null)
    {
        $this->_response = $response;
        parent::__construct('Received HTTP Error ' . $errorNo . ' ' . $errorStr, $errorNo);
    }

    /**
     * stringify, include response
     * @return string
     */
    public function __toString(): string
    {
        $string = parent::__toString();
        return $this->_response.PHP_EOL.PHP_EOL.$string;
    }
}